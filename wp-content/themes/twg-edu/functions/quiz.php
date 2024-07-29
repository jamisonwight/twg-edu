<?php 

function quiz($category = '', $nextPage = '') {
    // Read the JSON file 
    $json = file_get_contents(get_template_directory().'/json/quiz.json');

    // Decode the JSON file
    $quiz_data = json_decode($json,true);

    if (!empty($category)) {
        query_questions_by_category($quiz_data, $category, $nextPage);
        return;
    }

    // User Quiz Form
    $quiz_user_form_fields = get_quiz_user_form_fields();
    get_quiz_form($quiz_user_form_fields);

    echo '
        <div class="quiz hide" data-quiz-total="
        '. get_questions_total_count($quiz_data['questions']) .'">
    ';

    // Nav & Progress Bar
    echo '
        <div class="quiz-progress hide">
            <span class="back">Back</span>
            <span class="next">Next</span>
            <div class="counter"></div>
            <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-meter" style="width:0%;"></div>
            </div>
        </div>
    ';

    echo '
        <div class="quiz-question-wrapper"> 
    ';

    foreach ($quiz_data['questions'] as $key => $q) {
        if ($q['type'] == 'multiple-options') {
            echo '
                <div class="quiz-item quiz-item-'. $key .' quiz-multiple-options'. get_hide_class($key) .'" id="quiz-'. $key .'">
                    <div class="quiz-heading">
                        <span class="heading-2">'. $q['question'] .'</span>
                    </div>
                    <div class="question-container"> 
                        <div class="option-headings">
                            <div class="label-heading"><span class="heading-3">'. $q['label_heading'] .'</span></div>
                            <div class="labels">'. get_quiz_labels($q['labels']) .'</div>
                        </div>
                    '. get_multiple_options($q['options']) .'
                    </div>
                </div>
            ';
        } else {
            echo '
                <div class="quiz-item quiz-item-'. $key . get_hide_class($key) .'" id="quiz-'. $key .'">
                    <div class="quiz-heading">
                        <span class="heading-2">'. $q['question'] .'</span>
                    </div> 
                    <div class="question-container">
                        <div class="form-wrapper">
                            <form class="option" data-answer="'. $q['answer'] .'">
                                <div class="options options-layout-'. $q['options_layout'] .'"">'
                                    . get_quiz_options($q['options'], $q['answer'], $key) .'
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            ';
        }
    }

    // End of quiz question wrapper 
    echo '
        </div> 
    ';

    // Next Button
    echo '
        <div class="next-container container">
            <div class="next hide">
                <span class="btn-default">Next</span>
            </div>
            <span class="back">back</span>
        </div>
    ';

    // Finish Button
    echo '
        <div class="finish hide">
            <span class="btn-default">Finish</span>
        </div>
    ';

    echo '</div>';
}

function get_quiz_user_form_fields() {
    $form_fields = array(
        'retest' => (isset($_GET['retest'])) ? $_GET['retest'] : 'false',
        'first_name' => (isset($_GET['first_name'])) ? $_GET['first_name'] : '',
        'last_name' => (isset($_GET['last_name'])) ? $_GET['last_name'] : '',
        'email' => (isset($_GET['email'])) ? $_GET['email'] : '',
        'date_of_birth' => (isset($_GET['date_of_birth'])) ? $_GET['date_of_birth'] : '',
        'sign_up' => (isset($_GET['sign_up'])) ? $_GET['sign_up'] : '',
    );
   return $form_fields;
}

function get_quiz_form($form_fields) {
    $is_retest = $form_fields['retest'];

    echo '
        <div class="quiz-form" data-is-retest="'. $is_retest .'">
            <div class="description">
                <h1 class="heading-1">Quiz Certification</h1>
            </div>
            '. do_shortcode('[contact-form-7 id="10" title="quiz form"]') .'
            <a class="btn-default" href="#" id="take-quiz">Take Quiz</a>
        </div>
    ';
}

function query_questions_by_category($quiz_data, $category, $nextPage) {
    echo '
        <div class="quiz quiz-category"
            data-quiz-category="'. $category .'"
            data-next-page="'. $nextPage .'" 
            data-quiz-total="'. get_questions_total_count($quiz_data['questions'], $category) .'">
    ';

    echo '
        <div class="quiz-question-wrapper">
    ';

    // Create new category array
    $categories = array();
    foreach ($quiz_data['questions'] as $key => $q) {
        if ($q['category'] == $category) {
            array_push($categories, $q);
        }
    }

    // Loop categories
    foreach ($categories as $key => $q) {
        if ($q['category'] == $category) {
            if ($q['type'] == 'multiple-options') {
                echo '
                    <div 
                        class="quiz-item quiz-item-'. $key .' quiz-multiple-options'. get_hide_class($key) .'" 
                        id="quiz-'. $key .'">
                        <div class="quiz-heading">
                            <span class="heading-2">Practice Your Knowledge</span>
                        </div>
                        <div class="question-container">  
                            <div class="question heading-3">'. $q['question'] .'</div>
                            <div class="options">
                                <div class="label-heading"><span class="heading-3">'. $q['label_heading'] .'</span></div>
                                <div class="labels">'. get_quiz_labels($q['labels']) .'</div>
                            </div>
                            <div class="options options-layout-'. $q['options_layout'] .'">
                                '. get_multiple_options($q['options']) .'
                            </div>
                            <div class="check-answer">
                                <div class="check-toggle">Check Your Answer »</div>
                                <div class="check-response">
                                    <span class="correct">'. $q['checkAnswer']['correct'] .'</span>
                                    <span class="incorrect">'. $q['checkAnswer']['incorrect'] .'</span>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            } else {
                echo '
                    <div class="quiz-item quiz-item-'. $key . get_hide_class($key) .'" id="quiz-'. $key .'">
                        <div class="quiz-heading">
                            <span class="heading-2">Practice Your Knowledge</span>
                        </div>  
                        <div class="question-container">
                            <div class="question heading-3">'. $q['question'] .'</div>
                            <div class="form-wrapper">
                                <form class="option" data-answer="'. $q['answer'] .'">
                                    <div class="options options-layout-'. $q['options_layout'] .'"">'
                                        . get_quiz_options($q['options'], $q['answer'], $key) .'
                                    </div>
                                </form>
                            </div>
                            <div class="check-answer">
                                <div class="check-toggle">Check Your Answer »</div>
                                <div class="check-response hide">
                                    <span class="correct hide">'. $q['checkAnswer']['correct'] .'</span>
                                    <span class="incorrect hide">'. $q['checkAnswer']['incorrect'] .'</span>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
        }
    }

    // End of quiz question wrapper
    echo '
        </div>
    ';

    echo '
        <div class="next">
            <span class="btn-default">Next</span>
        </div>
    ';

    echo '</div>';
}

function get_hide_class($key) {
    if ($key !== 0) return ' quiz-hide';
}

function get_questions_total_count($questions, $category = '') {
    $question_count_total = 0;

    foreach ($questions as $key => $q) {
        if ($category != '') {
            if ($q['category'] == $category) {
                $question_count_total++;
            }
        } else {
            $question_count_total++;
        }
    }
    return $question_count_total;
}

function get_quiz_labels($labelArray) {
    $output = '';

    foreach ($labelArray as $l) {
        $output .=  '
            <span class="category heading-3">'. $l .'</span>
        ';
    }
    return $output;
}

function get_multiple_options($options) {
    $output = '';

    foreach ($options as $o) {
        $output .=  '
           <div class="form-wrapper">
                <span class="title">'. $o['title'] .'</span>
                <form class="option" data-answer="'. $o['answer'] .'">
                    <label><input type="radio" name="'. $o['title'] .'" value="reds" /></label>
                    <label><input type="radio" name="'. $o['title'] .'" value="whites" /></label>
                </form>
            </div>
        ';
    }
    return $output;
}

function get_quiz_options($options, $answer, $key) {
    $output = '';

    foreach ($options as $o) {
        $output .=  '
            <div class="option-select">
                <input type="radio" id="'. $o .'-'. $key .'" name="quiz-question-'. $key .'" value="'. $o .'" />
                <label for="'. $o .'-'. $key .'">'. $o .'</label>
            </div>
        ';
    }
    return $output;
}