<?php

class ScanResults{
    private $xmlObject;

    private $totalItems;

    private $totalSize;

    private $response;

    public function __construct($fileName, $path='')
    {
        $this->xmlObject = simplexml_load_string(file_get_contents($path.$fileName.'.xml'));
        //var_dump($this->xmlObject);
        $this->response = [
            'type' => (string)$this->xmlObject['type'],
            'totalSize' => self::calculate_totalSize(), // O(n)
            'totalItems' => self::calculate_totalItems(), // O(n)
            'results' => array(
                'folders' => array()
            )
        ];
        $this->parse_folders(); // O(n^2)
        
        //Worst Case O(n^2)

    }

    public function get_results(){
        //var_dump($this->xmlObject);
        return json_encode($this->response);
    }

    public function get_type(){
        return $this->xmlObject['type'];
    }

    private function parse_folders(){
        for( $i = 0; ($i <= (count($this->xmlObject->dir) - 1)); $i++) {
            // O(n)
            $this->response['results']['folders'][] = array(
                'location' => (string)$this->xmlObject->dir[$i]['name'],

                'totalSize' => (string)$this->xmlObject->dir[$i]['sizeBytes'],

                'totalItems' => (string)$this->xmlObject->dir[$i]['items'],
            );

            for( $j = 0; ($j <= $this->xmlObject->dir[$i]['items'] - 1); $j++)
            //O(n)
            {
                $this->response['results']['folders'][$i]['files'][] = array(
                    'file' => (string)$this->xmlObject->dir[$i]->file[$j]['path'],
                    'size' => (string)$this->xmlObject->dir[$i]->file[$j]['sizeBytes']
                );
            }
        }
        # Time Complexity - O(n^2)

    }

    private function calculate_totalSize(){
        for( $i = 0; ($i <= (count($this->xmlObject->dir) - 1)); $i++){ //Iterate on Folders
            $this->totalSize += $this->xmlObject->dir[$i]['sizeBytes'];
        }
        # Time Complexity - O(n)

        return $this->totalSize;
    }

    public function calculate_totalItems(){
        for( $i = 0; ($i <= (count($this->xmlObject->dir) - 1)); $i++){ //Iterate on Folders
            $this->totalItems += $this->xmlObject->dir[$i]['items'];
        }
        # Time Complexity - O(n)

        return $this->totalItems;
    }

}
