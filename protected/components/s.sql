UPDATE nations SET count = (SELECT COUNT(id) FROM poets WHERE poets.nation = nations.id);
UPDATE node SET a_count = (SELECT COUNT(b.*) FROM node a1, edge b WHERE a1.id = node.id);

update node
JOIN (
  select b.*, count(*) as counter from node a1, edge b
    where ((a1.id=b.node_id and a2.id=b.target_node_id ) or (a1.id=b.target_node_id and a2.id=b.node_id ))
    and b.edge = 'associate'
) as res
ON
res.id = node.id
set t.a_count = res.counter;



UPDATE table1 t1
SET t1.val1 =
(SELECT val FROM table2 t2 WHERE t2.id = t1.t2_id )
WHERE t1.val1 = '';

UPDATE node2 set a_count = (SELECT COUNT(*) as counter FROM node a1, edge b WHERE a1.id = node2.id and b.target_node_id = a1.id and b.edge = 'associate') as c1,

UPDATE node2 set a_count = c1.counter + c2.counter
 (SELECT COUNT(*) as counter FROM node a1, edge b WHERE a1.id = 1000 and b.target_node_id = a1.id and b.edge = 'associate') as c1,
 (SELECT COUNT(*) as counter FROM node a1, edge b WHERE a1.id = 1000 and b.node_id = a1.id and b.edge = 'associate') as c2
