<?php

class RunController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "Index"          => "Управление товарами",
            "Update"         => "Управление товарами",
            "Runn"           => "Управление товарами",
            'Get'            => 'Отдать соседей для заданного нода',
        );
    }


    public function actionBisec()
    {
        $c    = Yii::app()->db->getCommandBuilder()
            ->createFindCommand('edge', new CDbCriteria(array('condition'=> 't.edge="associate"')));
        $data = $c->limit(1000)->query();
        $n    = Node::model()->count();
        $tmp  = array_fill(0, $n, 10000);
        $W    = array_fill(0, $n, $tmp);
        $k    = 0;

        foreach ($data as $item)
        {
            $i         = (int)$item['node_id'];
            $j         = (int)$item['target_node_id'];
            $W[$i][$j] = $W[$j][$i] = 1;
            if (++$k > 100)
            {
                break;
            }
        }
        Y::end(round(memory_get_peak_usage() / (1024 * 1024), 2) . "MB");


        $f = Yii::getPathOfAlias('application') . '/../gr.txt';
        Y::dump(file_put_contents($f, json_encode($W)));

        // Initialization
        for ($i = 0; $i < $n; $i++)
        {
            $W[$i][$i] = INF;
        }
        $f = Yii::getPathOfAlias('application') . '/../gr.txt';
        Y::dump(file_put_contents($f, json_encode($W)));
        // Algorithm
        for ($k = 0; $k < $n; $k++)
        {
            for ($i = 0; $i < $n; $i++)
            {
                for ($j = 0; $j < $n; $j++)
                {
                    $W[$i][$j] = min($W[$i][$j], $W[$i][$k] + $W[$k][$j]);
                }
            }
            if ($k == 10)
            {
                break;
            }
        }
        Y::end($W);
    }


    public function addNodes($n, &$res, $count = 5)
    {
        foreach ($n->with('target_node')->edges as $k)
        {
            if (!isset($this->edges[$k->node_id][$k->target_node_id]) &&
                !isset($this->edges[$k->target_node_id][$k->node_id])
            )
//            if (!isset($this->edges[$n->id][$k->id]) && !isset($this->edges[$k->id][$n->id]))
            {
//                $this->edges[$k->node_id][$k->target_node_id] = $this->edges[$k->target_node_id][$k->node_id] = 1;
                $this->edges[$k->node_id][$k->target_node_id] = $this->edges[$k->target_node_id][$k->node_id] = true;
                $res['links'][]              = array(
                    'source'=> (int)$k->node_id,
                    'target'=> (int)$k->target_node_id,
                    'type'  => $k->edge,
//                $res['links'][] = array(
//                    'source'=> (int)$n->id,
//                    'target'=> (int)$k->id,
//                    'type'  => 'associate',
                );
            }
            $node = $k->target_node;
//            $node           = $k;
            if ($node->id == $n->id)
            {
                $node = $k->source_node;
            }
//
            if (isset($this->nodes[$node->id]))
            {
                continue;
            }

            $this->nodes[$node->id] = true;
            $res['nodes'][]         = array(
                'name'    => $node->id,
                'title'   => $node->title,
                'e_count' => $node->edges_count,
                'weight'  => 2,
                'group'   => 1,
            );
            if ($count && $node)
            {
                $this->addNodes($node, $res, $count - 1);
            }
        }

    }


    public $nodes = array();
    public $edges = array();


    public function actionGet($id)
    {
        $nodes = Node::model()->findAllByPk($id);
        $this->actionRunn($nodes);
    }


    public function actionAutocomplete()
    {
        if ($phrase = Yii::app()->request->getParam('q'))
        {
            $model = Node::model();
            $res   = '';
            foreach ($model->limit(10)->autocomplete($phrase)->findAll() as $item)
            {
                $res .= $item->title . "\n";
            }
            echo $res;
        }
    }

    public function actionSearch()
    {
        $phrase = Yii::app()->request->getPost('search');
        $nodes = Node::model()->findAllByAttributes(array('title'=>$phrase));
        $this->actionRunn($nodes);
    }

    public function actionRunn($models = null)
    {

        try
        {
            $data = array();
//            for ($i = 0; $i < 6; $i++)
//            {
//                $data[] = rand(1, 80000);
//            }
//            $models = Node::model()->in('id', $data)->findAll();
            if ($models == null)
            {
                $cr = new CDbCriteria();
                $cr->compare('t.title', $phrase, true);
                $models = Node::model()->limit(1)->findAll($cr);
            }
            $res = array(
                'nodes'=> array(),
                'links'=> array()
            );
            $i   = 0;
            foreach ($models as $n)
            {
                if (isset($this->nodes[$n->id]))
                {
                    continue;
                }
                $this->nodes[$n->id] = true;
                $res['nodes'][] = array(
                    'name'   => $n->id,
                    'title'  => $n->title,
                    'weight' => 2,
                    'group'  => 1
                );
                $this->addNodes($n, $res, 0);
            }
            echo CJSON::encode($res);
        } catch (Exception $e)
        {
            Yii::app()->handleException($e);
        }
    }


    public function actionIndex()
    {
        $this->render('index');
    }


    public function actionCalc()
    {
        foreach (Node::model()->findAll() as $node)
        {
            $node->a_count = $node->getAllAssociates();
            $node->save(false);
        }
    }


    public function actionUpdate()
    {
        $ids = Yii::app()->db->createCommand()->from('node')->where('gr IS NULL')->queryColumn(array('id'));
        foreach ($ids as $id)
        {
            $node = Node::model()->findByPk($id);
            if ($node->gr === null)
            {
                $node->gr = $node->id;
                $node->save(false, array('gr'));
            }
            $this->recUpdate($node, 5);
        }
    }

    public function recUpdate($node, $count = 10)
    {
        if ($count <= 0)
        {
            return;
        }
        foreach ($node->getAllAssociates() as $ass)
        {
            if ($ass->gr !== null)
            {
                continue;
            }
            $ass->gr = $node->gr;
            $ass->save(false, array('gr'));
            $this->recUpdate($ass, --$count);
            unset($ass);
        }
    }

    public function actionExperiments()
    {
        $cr = new CDbCriteria(array(
            'condition' => 't.edge = "subclass_of"'
        ));
        $model = new Edge;
        $model->getDbCriteria()->mergeWith($cr);
        $models = $model->findAllRaw();
        foreach ($models as $model)
        {
            if (!($n1 = Node::model()->findByPk($model['node_id'])))
            {
                continue;
            }
            if (!($n2 = Node::model()->findByPk($model['target_node_id'])))
            {
                continue;
            }
            if ($n1->main_gr4 != null)
            {
                continue;
            }

            $n1->main_gr4 = $n2->id;
            $n1->save(false);
            $n2->save(false);
        }
    }

}

