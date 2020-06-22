<?php
/*
    Solution to the problem INOROUT; https://www.spoj.com/problems/INOROUT/
    Author: igarash1
*/

function IsInsideThePolygon($point, $vertex)
{
    // printf("%d %d\n", $point['x'], $point['y']);

    // $numOfVertex : the number of the vertices
    $numOfVertex = count($vertex);
    // $count : the number of intersections of a ray, starting from the point and going in the direction of the positive x-axis, with all sides of the polygon.
    $count = 0;
    $EPS = 0.00001;
    
    for ($i = 0; $i < $numOfVertex; ++$i) {
        // printf("%d %d\n", $vertex[$i]['x'], $vertex[$i]['y']);
        // Is the point on the vertex[i]?
        if (abs($vertex[$i]['y'] - $point['y']) < $EPS && abs($vertex[$i]['x'] - $point['x']) < $EPS) {
            return 1;
        }

        $j = ($i + 1) % $numOfVertex;

        // Is the the ray intersects the edge (vertex[i],vertex[j])? 
        if ($point['y'] > min($vertex[$i]['y'], $vertex[$j]['y']) 
            && $point['y'] <= max($vertex[$i]['y'], $vertex[$j]['y'])
            && $point['x'] <= max($vertex[$i]['x'], $vertex[$j]['x'])
        ) {
            // pos_x : x-coordinate of the intersection point
            $pos_x = ($point['y'] - $vertex[$i]['y']) * ($vertex[$j]['x'] - $vertex[$i]['x'])
                        / ($vertex[$j]['y'] - $vertex[$i]['y']) + $vertex[$i]['x'];

            // Is the point on the edge?
            if (abs($pos_x - $point['x']) < $EPS) return 1;

            // Does the ray intersect the edge?
            if ($point['x'] <= $pos_x || abs($vertex[$i]['x'] - $vertex[$j]['x']) < EPS) $count++;
        }
    }

    // echo "count = $count\n";

    // the point is inside the polygon iff $count is odd
    return $count % 2;
}

fscanf(STDIN, "%d %d", $N, $Q);

$vertex_in = explode(' ', fgets(STDIN));
$vertex = array();
for ($i = 0; $i < $N; ++$i) {
    $vertex[$i] = array("x" => (double)$vertex_in[2 * $i],"y" => (double)$vertex_in[2 * $i + 1]);
}

for ($i = 0; $i < $Q; ++$i) {
    fscanf(STDIN, "%d %d", $point['x'], $point['y']);
    if(IsInsideThePolygon($point, $vertex)) printf("D\n");
    else printf("F\n");
}

?>