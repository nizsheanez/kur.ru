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
            $i         = (int)$item['source'];
            $j         = (int)$item['target'];
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
        foreach ($n->with('target_node', 'source_node')->getAllEdges() as $k)
        {
            if (!isset($this->edges[$k->source][$k->target]) &&
                !isset($this->edges[$k->target][$k->source])
            )
//            if (!isset($this->edges[$n->id][$k->id]) && !isset($this->edges[$k->id][$n->id]))
            {
//                $this->edges[$k->source][$k->target] = $this->edges[$k->target][$k->source] = 1;
                $this->edges[$k->source][$k->target] = $this->edges[$k->target][$k->source] = true;
                $res['links'][]              = array(
                    'source'=> (int)$k->source,
                    'target'=> (int)$k->target,
                    'type'  => $k->edge,
                    'id' => $k->id
//                $res['links'][] = array(
//                    'source'=> (int)$n->id,
//                    'target'=> (int)$k->id,
//                    'type'  => 'associate',
                );
            }

            $node = $k->source == $n->id ? $k->target_node : $k->source_node;
//            $node           = $k;

            if (isset($this->nodes[$node->id]))
            {
                continue;
            }

            $this->nodes[$node->id] = true;
            $res['nodes'][]         = array(
                'name'    => $node->id,
                'title'   => $node->title,
                'e_count' => $node->edges_count,
                'visible_edge_count' => 0,
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
        $this->actionSearch($nodes);
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

    public function actionSearch($models = null)
    {
        try
        {
//            $data = array();
//            for ($i = 0; $i < 6; $i++)
//            {
//                $data[] = rand(1, 80000);
//            }
//            $models = Node::model()->in('id', $data)->findAll();
            $phrase = Yii::app()->request->getParam('search');
            $models = $models ? $models : Node::model()->findAllByAttributes(array('title'=>$phrase));
            $res = array(
                'nodes'=> array(),
                'links'=> array()
            );
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
                    'e_count'  => $n->edges_count,
                    'visible_edge_count' => 0,
                );
                $this->addNodes($n, $res, 0);
            }
            echo CJSON::encode($res);
        }
        catch (Exception $e)
        {
            Yii::app()->handleException($e);
        }
    }


    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionSave($ids = null)
    {
        if ($ids === null)
        {
            $ids = array();
            for ($i = 0; $i < 20; $i++)
            {
                $ids[] = rand(0, 80000);
            }
        }

        $nodes = Node::model()->in('id', $ids)->findAll();
        $triples = array();
        foreach ($nodes as $node)
        {
            $triples[trim($node->title)] = $node->toTriplet();
        }

        require Yii::getPathOfAlias('ext.arc.ARC2').'.php';
        $ns = array(
            'foaf' => 'http://xmlns.com/foaf/0.1/',
            'dc' => 'http://purl.org/dc/elements/1.1/'
        );
        $conf = array('ns' => $ns);
        $ser = ARC2::getRDFXMLSerializer($conf);
        $doc = $ser->getSerializedIndex($triples);
        dump($doc);
    }

}

