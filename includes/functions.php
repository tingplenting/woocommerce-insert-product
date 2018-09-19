<?php

function multiCurl($urls, $user_agent, $folder, $filename) {

    $filepaths = array();

    // cURL multi-handle
    $mh = curl_multi_init();

    // This will hold cURLS requests for each file
    $requests = array();

    $options = array(
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_AUTOREFERER    => true, 
        CURLOPT_USERAGENT      => $user_agent,
        CURLOPT_HEADER         => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 120,
        CURLOPT_RETURNTRANSFER => true
    );

    //Corresponding filestream array for each file
    $fstreams = array();
    $i = 0;
    foreach ($urls as $key => $url) {
        // Add initialized cURL object to array
        $requests[$key] = curl_init($url);

        // Set cURL object options
        curl_setopt_array($requests[$key], $options);
        // Extract filename from URl and create appropriate local path
        // $path     = parse_url($url, PHP_URL_PATH);
        // $filename = pathinfo($path, PATHINFO_BASENAME); // Or whatever you want

        $filepath = $folder . $filename[$i];

        $filepaths []= $filepath;

        // Open a filestream for each file and assign it to corresponding cURL object
        $fstreams[$key] = fopen($filepath, 'w');
        curl_setopt($requests[$key], CURLOPT_FILE, $fstreams[$key]);

        // Add cURL object to multi-handle
        curl_multi_add_handle($mh, $requests[$key]);
        $i++;
    }

    // Do while all request have been completed
    do {
       curl_multi_exec($mh, $active);
    } while ($active > 0);

    
    // Collect all data here and clean up

    foreach ($requests as $key => $request) {

        //$returned[$key] = curl_multi_getcontent($request); // Use this if you're not downloading into file, also remove CURLOPT_FILE option and fstreams array
        curl_multi_remove_handle($mh, $request); //assuming we're being responsible about our resource management
        curl_close($request);                    //being responsible again.  THIS MUST GO AFTER curl_multi_getcontent();
        fclose($fstreams[$key]);
        
    }

    curl_multi_close($mh);

    return $filepaths;

}

// Find a randomDate between $start_date and $end_date
function randomDate($start_date, $end_date) {
    // Convert to timetamps
    $min = strtotime($start_date);
    $max = strtotime($end_date);

    // Generate random number using above bounds
    $val = rand($min, $max);

    // Convert back to desired date format
    return date('Y-m-d H:i:s', $val);
}

