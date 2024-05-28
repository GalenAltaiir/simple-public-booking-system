<?php

namespace App;

class Helpers
{
    public static function view($viewName, $data = [])
    {

        $viewPath = __DIR__ . "/../public/views";
        extract($data);

        $content = file_get_contents("{$viewPath}/{$viewName}.blade.php");

        $content = preg_replace("/{{s*(.+?)s*}}/", "<?php echo htmlspecialchars($1, ENT_QUOTES, 'UTF-8'); ?>", $content);

        $content = preg_replace("/@if\(\s*(.+?)\s*\)/", "<?php if($1): ?>", $content);
        $content = str_replace("@endif", "<?php endif; ?>", $content);

        $content = preg_replace("/@foreach\(\s*(.+?)\s*\)/", "<?php foreach($1): ?>", $content);
        $content = str_replace("@endforeach", "<?php endforeach; ?>", $content);

        $content = str_replace("@else", "<?php else: ?>", $content);


        // this method replicates very basic functionality of blade templating engine
        // as I'm avoiding using laravel for the demo for full flexibility.

        // Since I'm not familiar with Vue and Angular, the "frontend"
        // is just a simple html and css with some blade templating. 

        ob_start();
        eval ('?>' . $content . '<?php');
        $render = ob_get_clean();

        echo $render;
    }

    static function response() {
        return new class {
            public function json($data) {
                header('Content-Type: application/json');
                echo json_encode($data);
                exit;
            }
        };
    }
}