<!doctype html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>EasyGraph example</title>
    </head>
    <body>
        <?php
                // 1) Load EasyGraph library
            include_once('EasyGraph.php');
        
                // 2) Create data
            $data = Array(
                'leden' => 200,
                'únor' => 256,
                'březen' => 512,
                'duben' => 128,
                'květen' => 64,
                'červen' => 512,
                'červenec' => 500,
                'srpen' => 128,
                'září' => 1024,
                'říjen' => 2000,
                'listopad' => 20,
                'prosinec' => 512
            );
            
                // 3) Create graph
            $graph = new \EasyGraphs\Line($data);
            
                // 4) Settings
            $graph->width = 1000;
            $graph->height = 300;
            
                // 5) Render graph
            echo $graph->render();
            
        ?>
    </body>
</html>