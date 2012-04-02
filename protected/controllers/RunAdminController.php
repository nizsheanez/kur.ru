<?php
class RunAdminController extends BaseController
{
    public static function actionsTitles()
    {
        return array(
            "Go"  => "Парсинг сети",
            "Calculate" => "Пересчет счетчиков"
        );
    }


    public function actionGo()
    {
        $netw = file_get_contents('D:\snetwork.txt');
        $netw = explode(":П:", $netw);
        array_shift($netw);

        $res = array();
        /*
        * П - очередная вершина (если не пуста, то вершина является понятийной, образующеей)
        * Если в вершину сети входит хотя бы одно ребро, то она должна иметь уникальное текстовое наименование, которое задается в поле :П:
        *
        * T - термин (через // аббревиатура)
        * Е - термин на английском
        *
        * Ч - это есть
        * О - ассоциативная связь
        */

 /*

 Если у вершины есть родитель(subclass_of), то заменяем ее группу на группу родительскую,
 а так же присваиваем эту группу всем ее синонимам, переводам, и определениям
 Иначе у вершины нет группы, добавляем ей новую группу.

  */
        $types = array(
            ':T:' => 'sinonim',
            ':O:' => 'associate',
            ':П:' => 'subclass_of',
            ':Ч:' => 'is_a',
            ':E:' => 'english',
        );

        foreach ($netw as $line)
        {
            //            if (150 == $i++)
            //            {
            //                break;
            //            }
            $tmp  = array();
            $last = $node = null;
            foreach (explode("\r\n", trim(':П: '.$line)) as $item)
            {

                $item_do = trim($item);
                if ($item_do[0] === ':')
                {
                    list($last, $literal) = explode(' ', $item_do, 2);
                    if (!$literal)
                    {
                        continue;
                    }
                    if (!$node && $last === ':T:')
                    {
                        $node = $literal;
                        continue;
                    }
                }
                else
                {
                    $literal = $item_do;
                }
                $tmp[$types[$last]][] = trim($literal);
            }
            $res[trim($node)] = $tmp;
        }

        $sn   = new Node;
        $se   = new Edge;
        $cash = array();
        foreach ($res as $node => $val)
        {
            if (!isset($cash[$node]))
            {
                $n        = clone $sn;
                $n->title = $node;
//                $n->save(false);
                $cash[$node] = $n->id;
            }
            else
            {
                $n = $sn->findByPk($cash[$node]);
            }

            foreach ($val as $edge => $nodes)
            {
                foreach ($nodes as $node2)
                {
                    if (!isset($cash[$node2]))
                    {
                        $n2        = clone $sn;
                        $n2->title = $node2;
                        $n2->save(false);
                        $cash[$node2] = $n2->id;
                    }
                    else
                    {
                        $n2 = $sn->findByPk($cash[$node2]);
                    }
                    $e                 = clone $se;
                    $e->edge           = $edge;
                    $e->node_id        = $n->id;
                    $e->target_node_id = $n2->id;
                    $e->save(false);
                }
            }
        }
    }
}
