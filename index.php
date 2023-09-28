<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Word Frequency Counter</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
<body>
    <h1>Word Frequency Counter</h1>
    
    <form action="process.php" method="post">
        <label for="text">Paste your text here:</label><br>
        <textarea id="text" name="text" rows="10" cols="50" required></textarea><br><br>
        
        <label for="sort">Sort by frequency:</label>
        <select id="sort" name="sort">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select><br><br>
        
        <label for="limit">Number of words to display:</label>
        <input type="number" id="limit" name="limit" value="10" min="1"><br><br>
        
        <input type="submit" value="Calculate Word Frequency">
    </form>

    <?php
   
    function tokenizeText($text) {
        
        $words = str_word_count($text, 1);
        return $words;
    }

    function calculateWordFrequencies($words) {
        
        $stopWords = array("the", "and", "in", "of", "a", "to");

        $filteredWords = array_diff($words, $stopWords);

        $wordFrequencies = array_count_values($filteredWords);

        return $wordFrequencies;
    }

    
    function sortWordFrequencies($wordFrequencies, $sortOrder) {
        if ($sortOrder === "asc") {
            asort($wordFrequencies);
        } else {
            arsort($wordFrequencies);
        }

        return $wordFrequencies;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $text = $_POST["text"];
        $sortOrder = $_POST["sort"];
        $limit = $_POST["limit"];

       
        $words = tokenizeText($text);      
        $wordFrequencies = calculateWordFrequencies($words);
        $sortedWordFrequencies = sortWordFrequencies($wordFrequencies, $sortOrder);
     
        $count = 0;
        echo "<h2>Top $limit Words</h2>";
        echo "<ul>";
        foreach ($sortedWordFrequencies as $word => $frequency) {
            if ($count >= $limit) {
                break;
            }
            echo "<li>$word: $frequency</li>";
            $count++;
        }
        echo "</ul>";
    }
    ?> 
</body>
</html>
