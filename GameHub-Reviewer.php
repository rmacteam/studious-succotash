<?php
class Review {
    public $game, $user, $rating, $comment;
    function __construct($game, $user, $rating, $comment) {
        $this->game = $game;
        $this->user = $user;
        $this->rating = $rating;
        $this->comment = $comment;
    }
}
class GameHubReviewer {
    public $reviews = [];
    public function addReview($game, $user, $rating, $comment) {
        $this->reviews[] = new Review($game, $user, $rating, $comment);
    }
    public function listReviews() {
        foreach ($this->reviews as $r)
            echo "$r->game reviewed by $r->user: $r->rating/10 - $r->comment<br>";
    }
    public function averageRating($game) {
        $sum = 0; $count = 0;
        foreach ($this->reviews as $r)
            if ($r->game == $game) { $sum += $r->rating; $count++; }
        return $count ? $sum / $count : 0;
    }
    public function exportReviews($filename) {
        $data = [];
        foreach ($this->reviews as $r)
            $data[] = ["game"=>$r->game,"user"=>$r->user,"rating"=>$r->rating,"comment"=>$r->comment];
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    }
}

$gh = new GameHubReviewer();
$gh->addReview("Elden Ring", "zarokin", 10, "Amazing gameplay!");
$gh->addReview("Elden Ring", "alice", 9, "Great world.");
$gh->addReview("Portal 2", "bob", 8, "Mind bending puzzles.");
$gh->listReviews();
echo "Average for Elden Ring: " . $gh->averageRating("Elden Ring") . "<br>";
$gh->exportReviews("reviews.json");
?>