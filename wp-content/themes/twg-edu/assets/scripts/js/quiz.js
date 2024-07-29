import g from './globals'

if (g.elementInDom('.page-quiz-certificate')) {
    var certPDF = document.getElementById('cert'),
        triggerPDF = document.getElementById('pdf-cert')

        function generatePDF() {
            html2canvas(certPDF, {
                useCORS: true,
                dpi: 300, // Set to 300 DPI
                scale: 3,
                onrendered: function(canvas) {
            
                  var pdf = new jsPDF('p', 'pt', 'letter');
            
                  var pageHeight = 1920;
                  var pageWidth = 1080;
                  for (var i = 0; i <= certPDF.clientHeight / pageHeight; i++) {
                    var srcImg = canvas;
                    var sX = 0;
                    var sY = pageHeight * i; // start 1 pageHeight down for every new page
                    var sWidth = pageWidth;
                    var sHeight = pageHeight;
                    var dX = 0;
                    var dY = 0;
                    var dWidth = pageWidth;
                    var dHeight = pageHeight;
            
                    window.onePageCanvas = document.createElement("canvas");
                    onePageCanvas.setAttribute('width', pageWidth);
                    onePageCanvas.setAttribute('height', pageHeight);
                    var ctx = onePageCanvas.getContext('2d');
                    ctx.drawImage(srcImg, sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight);
            
                    var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);
                    var width = onePageCanvas.width;
                    var height = onePageCanvas.clientHeight;
            
                    if (i > 0) // if we're on anything other than the first page, add another page
                      pdf.addPage(612, 791); // 8.5" x 11" in pts (inches*72)
            
                    pdf.setPage(i + 1); // now we declare that we're working on that page
                    pdf.addImage(canvasDataURL, 'PNG', 0, 100, (width * .62), (height * .62)); // add content to the page
            
                  }
                  pdf.save('TWG_EDUCATION_CERTIFICATION.pdf');
                }
              });
        }

    triggerPDF.addEventListener('click', (e) => {
        e.preventDefault();
        window.print()
    })
}

if (g.elementInDom('.quiz')) {
    var baseURL = window.location.host,
        category = '',
        nextPage = '',
        activeQuestionIndex = 0,
        quiz = document.querySelector('.quiz'),
        quizItem = document.querySelector('.quiz-item-' + activeQuestionIndex),
        quizOptions = document.querySelectorAll('.quiz-qustion-' + activeQuestionIndex),
        hasCategory = g.elementInDom('.quiz-category'),
        correctAnswer = '',
        first_name = '',
        last_name = '',
        email = '',
        date_of_birth = '',
        newsletterSignUp = false,
        questionCount = 0,
        questionCorrectCount = 0,
        correctCount = 0,
        score = 0


        function startQuiz() {
            // Get total number of questions
            getQuestionCount()

            if (hasCategory) {
                category = quiz.dataset.quizCategory
                nextPage = quiz.dataset.nextPage
                getCategory(activeQuestionIndex)
            } else {
                quizTest()
            }
        }


        function getQuestionCount() {
            questionCount = parseInt(quiz.dataset.quizTotal)
        }


        function quizTest() {
            const quizForm = document.querySelector('.quiz-form')

            if (quizForm.dataset.isRetest === 'false') { 
                startQuizButton(quizForm) 
            } else {
                showQuiz(quizForm)

                getNextQuestion(activeQuestionIndex)

                getPrevQuestion(activeQuestionIndex)

                updateCounter(activeQuestionIndex)

                calculateProgressBar(activeQuestionIndex)
            }
        }


        function startQuizButton(quizForm) {
            const startButton = document.querySelector('#take-quiz'),
                  errorMessageEl = document.querySelector('.error-message')

            startButton.addEventListener('click', (e) => {
                e.preventDefault()

                new Promise((resolve) => {
                    resetErrorMessage(errorMessageEl)
                    resolve()
                })
                .then(() => {
                    validateForm(quizForm, errorMessageEl)
                })
                .catch((error) => {
                    console.log(error)
                })
            })
        }


        function initQuiz(quizForm) {
            showQuiz(quizForm)

            getNextQuestion(activeQuestionIndex)

            getPrevQuestion(activeQuestionIndex)

            updateCounter(activeQuestionIndex)

            calculateProgressBar(activeQuestionIndex)
        }


        function showQuiz(quizForm) {
            quiz.classList.remove('hide')
            quizForm.classList.add('hide')
            quiz.querySelector('.quiz-progress').classList.remove('hide')
    
            document.querySelectorAll('.next').forEach((obj, index) => {
                obj.classList.remove('hide')
            })
        }


        function calculateProgressBar(activeQuestionIndex) {
            quiz.querySelector('.progress-meter').style.width = getPercentage((activeQuestionIndex+=1), questionCount) + '%'
        }


        function getPercentage(partialValue, totalValue) {
            return Math.round((partialValue / totalValue) * 100)
         } 


        function updateCounter(activeQuestionIndex) {
            var counter = document.querySelector('.quiz-progress .counter')

            counter.innerHTML = `Question ${(activeQuestionIndex+=1)} of ${questionCount}`
        }


        function validateForm(quizForm, errorMessageEl) {
            var hasError = false,
                checkFields = [
                    'first_name',
                    'last_name',
                    'email',
                    'date_of_birth'
                ]

            quizForm.querySelectorAll('input').forEach((obj, index) => {
                checkFields.forEach((c) => {
                    if (c === obj.name 
                        && obj.value.length === 0) {
                            errorMessage(errorMessageEl, obj.name.replace(/_/g, " "))
                            hasError = true
                    }
                })

                // Set User information variables
                setUserInfo(obj)
            })
            
            // Block validation if any errors
            if (hasError) return showError(errorMessageEl)

            // If there are no errors start the quiz
            initQuiz(quizForm)
        }


        function setUserInfo(input) {
            switch (input.name) {
                case 'first_name':
                    first_name = input.value
                    break
                case 'last_name':
                    last_name = input.value
                    break
                case 'email':
                    email = input.value
                    break
                case 'date_of_birth':
                    date_of_birth = input.value
                    break
                case 'sign-up':
                    if (input.checked) {
                        newsletterSignUp = true
                    }
                    break
                default:
            }
        }


        function errorMessage(errorMessageEl, fieldName) {
            var newErrorElement = document.createElement('span')
            newErrorElement
                .innerHTML = 
                    "<strong>" + capitalizeString(fieldName) + "</strong> is required."

            errorMessageEl.appendChild(newErrorElement)
        }


        function capitalizeString(word) {
            return word.charAt(0).toUpperCase() + word.slice(1);
        }


        function resetErrorMessage(errorMessageEl) {
            errorMessageEl.querySelectorAll('span').forEach((obj, index) => {
                if (index !== 0) {
                    obj.remove()
                }
            })
        }


        function showError(errorMessage) {
            errorMessage.classList.remove('hide')
        }


        function getCategory(activeQuestionIndex) {
            quizItem = document.querySelector('.quiz-item-' + activeQuestionIndex)

            // Add first Correct answer
            getCorrectAnswer(activeQuestionIndex)

            // Set Check Answer toggle functionality based off correct answers
            answerToggle(activeQuestionIndex)

            // Setup navigation
            getNextQuestion(activeQuestionIndex, updateCounter = false)
        }


        function checkAnswer(index) {
            var form = quiz.querySelectorAll('.quiz-item form')[index],
                isMultiple = form.classList.contains('quiz-multiple-options'),
                options = (!isMultiple) 
                    ? quizItem.querySelectorAll('input[type="radio"]') 
                    : quiz.querySelectorAll('.form-wrapper form'),
                optionSelected = (isMultiple) 
                    ? getMultipleOptionsSelected(options, activeQuestionIndex)
                    : getOptionSelected(options, activeQuestionIndex)

            // Check if it's multiple options
            // Return true if none selected are incorrect
            if (isMultiple && optionSelected) {
                quizItem.querySelector('.correct').classList.remove('hide')
                quizItem.querySelector('.incorrect').classList.add('hide')
                return
            } 
            // Compare correct answer with selected answer
            else if (optionSelected === correctAnswer) {
                quizItem.querySelector('.correct').classList.remove('hide')
                quizItem.querySelector('.incorrect').classList.add('hide')
                return
            } 
                
            // Show Incorrect Message
            quizItem.querySelector('.incorrect').classList.remove('hide')
            quizItem.querySelector('.correct').classList.add('hide')
            
        }


        function getOptionSelected(options, index) {
            let optionSelected = ''

            options.forEach((obj, i) => {
                if (obj.checked) {
                    optionSelected = obj.value
                }

                // Hide check answer toggle on new selection
                obj.addEventListener('click', () => {
                   quizItem.querySelector('.check-response').classList.add('hide')
                })
            })
            return optionSelected
        }

        function getMultipleOptionsSelected(options, index) {
            let checkedValue = '',
                answersIncorrect = []

            options.forEach((obj, i) => {
                obj.querySelectorAll('input').forEach((i) => {
                    if (i.checked && i.value !== answer) {
                        answersIncorrect.push(i.value)
                    }
                })

                // Hide check answer toggle on new selection
                obj.addEventListener('click', () => {
                   quizItem.querySelector('.check-response').classList.add('hide')
                })
            })

            if (answersIncorrect.length === 0) {
                return true
            }
            return false
        }


        function answerToggle(index) {
            quizItem.querySelector('.check-toggle')
                .addEventListener('click', (event) => {
                    event.preventDefault()
                    quizItem.querySelector('.check-response').classList.remove('hide')
                    checkAnswer(activeQuestionIndex)
            })
        }


        function getCorrectAnswer(index) {
            var form = quizItem.querySelector('form'),
                answer = form.dataset.answer

            correctAnswer = answer
        }


        function getNextQuestion(questionIndex) {
            quiz.querySelectorAll('.next')
                .forEach((obj) => {
                    obj.addEventListener('click', (event) => {
                        event.preventDefault()
                        event.stopPropagation()
    
                    if (hasCategory) {
                        window.location = nextPage
                        return
                    }

                    updateIndex(activeQuestionIndex, 'next', true)
                })
            })
        }


        function getPrevQuestion(questionIndex) {
            quiz.querySelectorAll('.back')
                .forEach((obj) => {
                    obj.addEventListener('click', (event) => {
                        event.preventDefault()
                        event.stopPropagation()

                    updateIndex(activeQuestionIndex, 'prev', true)
                })
            })
        }


        function updateIndex(questionIndex, direction, isTest = false) {
            if (direction == 'prev') {
                if (questionIndex == (questionCount - 1)) {
                    if (isTest) {
                        finishHandler('hide')
                    }
                }

                if ((activeQuestionIndex - 1) <= 0) {
                    activeQuestionIndex = 0
    
                } else {
                    activeQuestionIndex = questionIndex-=1
                }
            } else {
                if ((questionIndex + 1) == (questionCount - 1)) {
                    if (isTest) {
                        finishHandler('show')
                    }
                }
            
                if (questionIndex >= (questionCount - 1)) {
                    activeQuestionIndex = 0
                } else {
                    activeQuestionIndex = questionIndex+=1
                }
            }

            quizItem.classList.add('quiz-hide')

            quizItem = document.querySelector('.quiz-item-' + activeQuestionIndex)

            setTimeout(() => {
                quizItem.classList.remove('quiz-hide')

                // Update question counter
                if (hasCategory) {
                    getCategory(activeQuestionIndex)
                    return
                }

                // Update question counter
                updateCounter((activeQuestionIndex))

                // Update Progress Bar
                calculateProgressBar(activeQuestionIndex)
            }, 600)
        }


        function finishHandler(display) {
            var finish = document.querySelector('.finish'),
                next = quiz.querySelectorAll('.next')

            if (display == 'show') {
                next.forEach((obj) => {
                    obj.classList.add('hide')
                })

                finish.classList.remove('hide')

                finish.addEventListener('click', (e) => {
                    e.preventDefault()
                    calculateTest()
                })
                return
            }

            next.forEach((obj) => {
                obj.classList.remove('hide')
            })

            finish.classList.add('hide')
        }


        function calculateTest() {
            quiz.querySelectorAll('.quiz-item').forEach((obj) => {
                if (obj.classList.contains('quiz-multiple-options')) {
                    console.log('calculating multiple options')
                    calculateMultipleOptions(obj)
                } else {
                    calculateOptions(obj)
                    console.log('calculating options')
                }
            })

            submitForm()
        }


        function calculateMultipleOptions(obj) {
            var answersIncorrect = []

            obj.querySelectorAll('.form-wrapper form').forEach((o) => {
                var answer = o.dataset.answer,
                    optionCount = 0,
                    notCheckedCount = 0

                o.querySelectorAll('input').forEach((i, index) => {
                    optionCount++

                    if (i.checked && i.value !== answer) {
                        answersIncorrect.push('incorrect')
                    } else if (!i.checked) {
                        notCheckedCount++
                    }
                })

                // Check if no options were selected
                // Consider question as incorrect
                if (notCheckedCount >= optionCount) {
                    answersIncorrect.push('incorrect')
                }
            })

            if (answersIncorrect.length === 0) {
                increaseCorrectCount()
            }
        }


        function calculateOptions(obj) {
            obj.querySelectorAll('form').forEach((o) => {
                var answer = o.dataset.answer

                obj.querySelectorAll('input').forEach((i) => {
                    if (i.checked && i.value === answer) {
                        increaseCorrectCount()
                    }
                })
            })
        }


        function increaseCorrectCount() {
            correctCount = correctCount+=1
        }


        function getResults(type) {
            switch (type) {
                case 'score':
                    return `${correctCount} out of ${questionCount} correct`
                    break
                case 'result':
                    var percentage = getPercentage(correctCount, questionCount)
                    
                    if (percentage >= 65) {
                        return 'passed'
                    } else {
                        return 'failed'
                    }
                    break
                case 'url':
                    return getRedirectURL()
                    break
                default:
            }
        }


        function getRedirectURL() {
            if (getResults('result') == 'failed') {
                return getParamsString('failed')
            }
            return getParamsString('passed')
        }


        function getParamsString(result) {
            var params = [
                `first_name=${first_name}`,
                `&last_name=${last_name}`,
                `&email=${email}`,
                `&date_of_birth=${date_of_birth}`,
                `&score=${getResults('score')}`,
                `&result=${getResults('result')}`,
            ]

            var url = `/quiz/${result}/?`

            params.forEach((str) => {
                url += str
            })
            return url
        }


        function setHiddenFields() {
            var scoreField = document.querySelector('#score'),
                resultField = document.querySelector('#result'),
                resultUrlField = document.querySelector('#result_url')

            scoreField.value = getResults('score')
            resultField.value = getResults('result')
            resultUrlField.value = getResults('url')
        }


        function submitForm() {
            const contactForm = document.getElementById('wpcf7-f10-o1')

            setHiddenFields()

            new Promise((resolve) => {
                contactForm.querySelector('.wpcf7-submit').click()
                resolve()
            })
            .then(() => {
                window.location.assign(getResults('url'))
            })
            .catch((error) => {
                console.log(error)
            })
        }
    startQuiz()
}