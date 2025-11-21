<?php


class ArrayStr {
    private $dato = [];

    public function append($item) {
        $this->dato[] = $item;
    }

    public function get($index) {
        return isset($this->dato[$index]) ? $this->dato[$index] : null;
    }

    public function display() {
        echo "Array: " . implode(', ', $this->dato) . "\n";
    }
}

// Clase para Nodo de Lista Enlazada
class ListNd {
    public $value;
    public $next;

    public function __construct($value) {
        $this->value = $value;
        $this->next = null;
    }
}

class LinkedList {
    private $head = null;

    public function append($value) {
        $newNode = new ListNd($value);
        if ($this->head === null) {
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current->next !== null) {
                $current = $current->next;
            }
            $current->next = $newNode;
        }
    }

    public function display() {
        $current = $this->head;
        $elements = [];
        while ($current !== null) {
            $elements[] = $current->value;
            $current = $current->next;
        }
        echo "Lista Enlazada: " . implode(' -> ', $elements) . "\n";
    }
}

class TreeNd {
    public $name;
    public $left;
    public $right;

    public function __construct($name) {
        $this->name = $name;
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree {
    private $root = null;

    public function insert($name) {
        $newNode = new TreeNd($name);
        if ($this->root === null) {
            $this->root = $newNode;
            return;
        }
        $queue = new Queue();
        $queue->enqueue($this->root);
        while (!$queue->isEmpty()) {
            $current = $queue->dequeue();
            if ($current->left === null) {
                $current->left = $newNode;
                return;
            } else {
                $queue->enqueue($current->left);
            }
            if ($current->right === null) {
                $current->right = $newNode;
                return;
            } else {
                $queue->enqueue($current->right);
            }
        }
    }

    public function search($name) {
        return $this->searchRec($this->root, $name);
    }

    private function searchRec($node, $name) {
        if ($node === null) {
            return null;
        }
        if ($node->name === $name) {
            return $node;
        }
        $left = $this->searchRec($node->left, $name);
        if ($left !== null) {
            return $left;
        }
        return $this->searchRec($node->right, $name);
    }

    public function inorderDisplay() {
        $result = [];
        $this->inorder($this->root, $result);
        echo "Árbol (inorden): " . implode(', ', $result) . "\n";
    }

    private function inorder($node, &$result) {
        if ($node !== null) {
            $this->inorder($node->left, $result);
            $result[] = $node->name;
            $this->inorder($node->right, $result);
        }
    }
}

class Queue {
    private $items = [];

    public function enqueue($item) {
        array_push($this->items, $item);
    }

    public function dequeue() {
        return array_shift($this->items);
    }

    public function isEmpty() {
        return empty($this->items);
    }

    public function peek() {
        return reset($this->items);
    }

    public function display() {
        echo "Cola: " . implode(', ', $this->items) . "\n";
    }
}

class Graf {
    private $adjList = [];

    public function addCity($city) {
        if (!isset($this->adjList[$city])) {
            $this->adjList[$city] = [];
        }
    }

    public function addRoute($city1, $city2, $distance) {
        $this->adjList[$city1][$city2] = $distance;
        $this->adjList[$city2][$city1] = $distance; 
    }

    public function getNeighbors($city) {
        return $this->adjList[$city] ?? [];
    }

    public function findPathBFS($start, $end) {
        $queue = new Queue();
        $queue->enqueue([$start]); 
        
        $visited = [];

        while (!$queue->isEmpty()) {
            $path = $queue->dequeue();
            $current = end($path);

            if (in_array($current, $visited)) {
                continue;
            }
            $visited[] = $current;

            if ($current === $end) {
                return $path; 
                
                
            }

            foreach ($this->getNeighbors($current) as $neighbor => $dist) {
                if (!in_array($neighbor, $visited)) {
                    $newPath = array_merge($path, [$neighbor]);
                    $queue->enqueue($newPath);
                }
            }
        }
        return null; 
    }
}


$array = new ArrayStr();
$list = new LinkedList();
$tree = new BinaryTree();
$queue = new Queue();
$graph = new Graf();

$towns = [
    'Bogotá', 
    'Chía', 
    'Zipaquirá', 
    'Ubaté', 
    'Chiquinquirá',
    'Saboyá',
    'Puente Nacional' 
];

foreach ($towns as $town) {
    $array->append($town);
    $list->append($town);
    $tree->insert($town);
    $graph->addCity($town);
}

$graph->addRoute('Bogotá', 'Chía', 23);
$graph->addRoute('Chía', 'Zipaquirá', 22);
$graph->addRoute('Zipaquirá', 'Ubaté', 45);
$graph->addRoute('Ubaté', 'Chiquinquirá', 53);
$graph->addRoute('Chiquinquirá', 'Saboyá', 13);
$graph->addRoute('Saboyá', 'Puente Nacional Sant', 26);

$graph->addRoute('Zipaquirá', 'Chiquinquirá', 97); 

echo "-- Array --\n";
$array->display();
echo "\n";

echo "-- Lista Enlazada --\n";
$list->display();
echo "\n";

echo "-- Árbol Binario --\n";

$tree->inorderDisplay();
echo "\n";

echo "-- Cola --\n";
$queue->enqueue('Tunja');
$queue->enqueue('Bucaramanga');
$queue->display();
$queue->dequeue();
$queue->display();
echo "\n";

echo "-- Búsqueda en Árbol --\n";
$searched = $tree->search('Ubaté');
echo $searched ? "Pueblo encontrado: " . $searched->name . "\n" : "Pueblo no encontrado\n";
echo "\n";

echo "-- Grafo (Ruta BFS) --\n";
$startCity = 'Bogotá';
$endCity = 'Puente Nacional Sant';
$path = $graph->findPathBFS($startCity, $endCity);
echo $path ? "Camino de $startCity a $endCity (BFS): " . implode(' -> ', $path) . "\n" : "No hay camino\n";

?>
