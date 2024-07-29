<?php /** Template Name: Quiz Failed */?>

<?php get_header();?>

<?php
class Quiz_Failed {
    public $first_name,
           $last_name,
           $email,
           $date_of_birth,
           $score;

    function __construct() {
        $this->first_name = $_GET['first_name'];
        $this->last_name = $_GET['last_name'];
        $this->email = $_GET['email'];
        $this->date_of_birth = $_GET['date_of_birth'];
        $this->score = $_GET['score'];
    }

    function getParams() {
        $params = array(
            'first_name='.$this->first_name,
            '&last_name='.$this->last_name,
            '&email='.$this->email,
            '&date_of_birth='.$this->date_of_birth,
            '&score='.$this->score,
        );

        $url = '';

        foreach ($params as $p) {
            $url .= $p;
        }

        echo $url;
    }

    function Get_URL() {
        echo $this->getParams();
    }

}
$quiz_failed = new Quiz_Failed();
?>

<div class="grid-container full page-quiz-failed quiz-result-page">
    <div class="wrapper">
        <div class="grid-x container">
            <div class="intro-description">
                <span class="title">Quiz Completed</span>
                <span class="heading-1">You Missed A Few</span>
                <span class="score">Score: <?php echo $quiz_failed->score; ?></span>
            </div>
            <div class="links">
                <a 
                    class="btn-default retake-quiz" 
                    href="<?php echo bloginfo('url'); ?>/quiz/?retest=true&<?php $quiz_failed->Get_URL(); ?>">
                    Re-take Test
                </a>
            </div>
        </div>
    </div>
</div>

<?php get_footer();?>