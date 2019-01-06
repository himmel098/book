(function ($) {
    $(document).ready(function () {
        initTestForm();
        initRangeSlider();
        initAnswerCanvas();
        initWeightsForm();
    });

    function initWeightsForm() {
        $('#weights_form').submit(function (e) {
            $('#error').addClass('hidden');
            var weightInputs = $(this).find('.weight-input'),
                sum = 0;

            $.each(weightInputs, function () {
                console.log($(this).val());
                sum += parseFloat($(this).val());
            });

            if (sum > 1 || sum < 0.999) {
                e.preventDefault();
                $('#error').removeClass('hidden');
                $('#success').addClass('hidden')
            } else {
                $('#success').removeClass('hidden')

            }

        });
    }

    function initAnswerCanvas() {

        var $canvas = $('.answer-canvas');

        if ($canvas.length === 0) {
            return;
        }

        var width = $canvas.width(),
            height = $canvas.height();


        $.each($canvas, function () {
            var ctx = this.getContext('2d');

            drawCoordinates(ctx);

            var data = JSON.parse($(this).attr("data-answer"));

            var coordinates = generateDataCoordinates(data);

            drawData(ctx, coordinates);
        });


        function drawCoordinates(ctx) {
            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.lineTo(width, height);
            ctx.stroke();
            ctx.moveTo(width, 0);
            ctx.lineTo(0, height);
            ctx.stroke();

            ctx.font = "16px Arial";
            ctx.fillText("Клан", 30, 20);
            ctx.fillText("Адхократія", width - 110, 20);
            ctx.fillText("Ієрархія", 30, height - 10);
            ctx.fillText("Ринок", width - 110, height - 10);

            var x = 0,
                y = 0,
                stepX = width / 20,
                stepY = height / 20;

            for (var i = 0; i < 22; i++) {
                ctx.beginPath();
                ctx.arc(x, y, 4, 0, 2 * Math.PI, false);
                ctx.fillStyle = 'black';
                ctx.fill();

                if (i === 5 || i === 15) {
                    ctx.fillText("50", x + 10, y);
                }

                x += stepX;
                y += stepY;
            }

            x = width;
            y = 0;
            for (var i = 0; i < 22; i++) {
                ctx.beginPath();
                ctx.arc(x, y, 4, 0, 2 * Math.PI, false);
                ctx.fillStyle = 'black';
                ctx.fill();

                if (i == 5 || i == 15) {
                    ctx.fillText("50", x + 10, y + 10);
                }

                x -= stepX;
                y += stepY;
            }
        }

        function generateDataCoordinates(data) {
            var result = {
                'current': [],
                'desirable': [],
                'perspective': []
            };

            result.current.push({
                'x': width / 2 - data.a_answer * 2,
                'y': height / 2 - data.a_answer * 2
            });

            result.current.push({
                'x': width / 2 + data.b_answer * 2,
                'y': height / 2 - data.b_answer * 2
            });

            result.current.push({
                'x': width / 2 + data.c_answer * 2,
                'y': height / 2 + data.c_answer * 2
            });

            result.current.push({
                'x': width / 2 - data.d_answer * 2,
                'y': height / 2 + data.d_answer * 2
            });

            result.desirable.push({
                'x': width / 2 - data.a_answer_desirable * 2,
                'y': height / 2 - data.a_answer_desirable * 2
            });

            result.desirable.push({
                'x': width / 2 + data.b_answer_desirable * 2,
                'y': height / 2 - data.b_answer_desirable * 2
            });

            result.desirable.push({
                'x': width / 2 + data.c_answer_desirable * 2,
                'y': height / 2 + data.c_answer_desirable * 2
            });

            result.desirable.push({
                'x': width / 2 - data.d_answer_desirable * 2,
                'y': height / 2 + data.d_answer_desirable * 2
            });

            result.perspective.push({
                'x': width / 2 - data.a_answer_perspective * 2,
                'y': height / 2 - data.a_answer_perspective * 2
            });

            result.perspective.push({
                'x': width / 2 + data.b_answer_perspective * 2,
                'y': height / 2 - data.b_answer_perspective * 2
            });

            result.perspective.push({
                'x': width / 2 + data.c_answer_perspective * 2,
                'y': height / 2 + data.c_answer_perspective * 2
            });

            result.perspective.push({
                'x': width / 2 - data.d_answer_perspective * 2,
                'y': height / 2 + data.d_answer_perspective * 2
            });

            return result;

        }

        function drawData(ctx, data) {
            for (var prop in data) {
                var column = data[prop];
                switch (prop) {
                    case 'current':
                        ctx.fillStyle = 'green';
                        ctx.strokeStyle = 'green';
                        break;
                    case 'desirable':
                        ctx.fillStyle = 'red';
                        ctx.strokeStyle = 'red';
                        break;
                    case 'perspective':
                        ctx.fillStyle = 'blue';
                        ctx.strokeStyle = 'blue';
                        break;

                }
                for (var i = 0; i < column.length; i++) {
                    ctx.beginPath();
                    ctx.arc(column[i].x, column[i].y, 3, 0, 2 * Math.PI, false);
                    ctx.fill();
                    ctx.moveTo(column[i].x, column[i].y);

                    if (i < column.length - 1) {
                        ctx.lineTo(column[i + 1].x, column[i + 1].y);
                    } else {
                        ctx.lineTo(column[0].x, column[0].y);
                    }

                    ctx.stroke();
                }
            }
        }
    }

    function initTestForm() {

        $('#addQuestion').on('click', function (e) {
            e.preventDefault();
            var questionNum = +$('#questionNum').val() + 1;
            $('#questionNum').val(questionNum);
            var html = '<div class="form-group">\n    ' +
                '<span class="delete-question">&times;</span>\n' +
                '<div class="container-fluid">\n        ' +
                '<div class="row">\n            ' +
                '<div class="col-sm-6">\n                ' +
                '<label for="question_' + questionNum + '">Питання ' + questionNum + '</label>\n                ' +
                '<input class="form-control" type="text" id="question_' + questionNum + '" name="questions[' + questionNum + '][text]">\n            ' +
                '</div>\n            <div class="col-sm-6">\n                ' +
                '<div class="form-group">\n                    ' +
                '<label for="question_' + questionNum + '_a">A:</label>\n                    ' +
                '<input class="form-control" type="text" id="question_' + questionNum + '_a" name="questions[' + questionNum + '][answers][a]">\n                ' +
                '</div>\n\n                ' +
                '<div class="form-group">\n                    ' +
                '<label for="question_' + questionNum + '_b">B:</label>\n                    ' +
                '<input class="form-control" type="text" id="question_' + questionNum + '_b" name="questions[' + questionNum + '][answers][b]">\n                ' +
                '</div>\n\n                ' +
                '<div class="form-group">\n                    ' +
                '<label for="question_' + questionNum + '_c">C:</label>\n                    ' +
                '<input class="form-control" type="text" id="question_' + questionNum + '_c" name="questions[' + questionNum + '][answers][c]">\n                ' +
                '</div>\n                ' +
                '<div class="form-group">\n                    ' +
                '<label for="question_' + questionNum + '_d">D:</label>\n                    ' +
                '<input class="form-control" type="text" id="question_' + questionNum + '_d" name="questions[' + questionNum + '][answers][d]">\n                ' +
                '</div>\n            ' +
                '</div>\n        ' +
                '</div>\n    ' +
                '</div>\n<' +
                '/div>';

            $(this).parent().before($(html));

            $('.delete-question').addClass('hidden').last().removeClass('hidden');

        });

        $(document).on('click', '.delete-question', function (e) {
            e.preventDefault();
            $(this).parent().remove();
            var questionNum = +$('#questionNum').val() - 1;
            $('#questionNum').val(questionNum);
            $('.delete-question').addClass('hidden').last().removeClass('hidden');

        });

        $('#questionsForm').on('submit', function (e) {
            var $inputs = $(this).find('input[type="text"]');
            $inputs.parent().removeClass('has-error');
            var isFormValid = true;
            $.each($inputs, function (i, input) {
                if ($(input).val() === '') {
                    $(input).parent().addClass('has-error');
                    isFormValid = false;
                }
            });
            if (!isFormValid) {
                e.preventDefault();
            }
        })

    }


    function initRangeSlider() {
        var $sliders = $('.vertical-range');
        if ($sliders.length !== 0) {
            $sliders.on('input', function (e) {
                var $labelWrapper = $(this).siblings('.range-label');
                var $labels = $labelWrapper.find('span');
                $($labels[0]).text($(this).val());
                $($labels[1]).text(100 - $(this).val());
            });
        }
    }

})(jQuery);
