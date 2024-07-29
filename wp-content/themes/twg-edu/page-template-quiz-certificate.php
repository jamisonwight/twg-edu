<?php /** Template Name: Quiz Certificate */?>

<?php get_header();?>

<?php
class Quiz_Certificate {
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
$quiz_cert = new Quiz_Certificate();
?>

<div class="grid-container full quiz-result-page page-quiz-certificate">
    <div class="wrapper">
        <div class="grid-x container">
            <div class="intro-description" id="cert">
                <div class="description-wrapper">
                    <span class="heading-1">Certificate</span>
                    <span class="heading-2">Of Completion</span>
                    <span class="heading-3 margin-top">This Certifies That</span>
                    <span class="name heading-1">
                        <?php echo $quiz_cert->first_name; ?>
                        <?php echo $quiz_cert->last_name; ?>
                        <hr>
                    </span>
                    <span class="heading-3">Has successfully completed</span>

                    <div class="cert-logo margin-top">
                        <img 
                            class="cert-circle"
                            src="<?php echo get_template_directory_uri(); ?>/assets/images/cert-circle.svg" 
                            alt="Certification Circle">
                        <img 
                            class="logo"
                            src="<?php echo get_template_directory_uri(); ?>/assets/images/twg-logo.png" 
                            alt="The Wine Group Logo">
                    </div>

                    <span class="heading-2 margin-top">Basic Wine Education Course</span>
                </div>
            </div>
            <div class="links">
                <a class="btn-default pdf-cert" href="#" id="pdf-cert">
                    Download PDF
                </a>
            </div>
        </div>
    </div>
</div>

<?php get_footer();?>