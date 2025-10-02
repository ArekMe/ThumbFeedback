(function(mw, $) {
    console.log("ThumbFeedback.js loaded");

    $(function() {
        console.log("ThumbFeedback DOM ready");

        const msgs = mw.config.get('ThumbFeedbackMessages') || {
            placeholder: 'Please provide feedback',
            submit: 'Submit',
            popupSuccess: 'Thank you for your feedback!',
            errorEmpty: 'Please select a vote or enter a comment.',
            errorSave: 'Error saving feedback!'
        };

        if ($('#thumb-feedback').length === 0) {
            // Wstawianie struktury HTML
            $('#content').append(`
                <div id="thumb-feedback" style="display:flex; gap:10px; align-items:flex-start; margin-top:20px;">
                    <div class="thumb-buttons-vertical">
                        <label class="thumb up">
                            <input type="radio" name="vote" value="1"> 👍
                        </label>
                        <label class="thumb down">
                            <input type="radio" name="vote" value="-1"> 👎
                        </label>
                    </div>
                    <form id="thumb-feedback-form" style="display:flex; flex:1; gap:5px; align-items:center;">
                        <textarea name="comment" style="flex:1; height:60px;"></textarea>
                        <button type="submit" style="height:60px;"></button>
                    </form>
                </div>
            `);

            // Ustawienie placeholdera i tekstu przycisku
            $('textarea[name="comment"]').attr('placeholder', msgs.placeholder);
            $('#thumb-feedback-form button[type="submit"]').text(msgs.submit);

            // Dopasowanie wysokości kontenera łapek do textarea
            const textareaHeight = $('#thumb-feedback textarea').outerHeight();
            $('.thumb-buttons-vertical').css({
                height: textareaHeight + 'px',
                display: 'flex',
                flexDirection: 'column',
                justifyContent: 'space-between'
            });
        }

        const form = $('#thumb-feedback-form');
        form.on('submit', function(e) {
            e.preventDefault();

            const vote = $('.thumb input[name="vote"]:checked').val() || 0;
            const comment = form.find('textarea[name="comment"]').val().trim();

            if (!vote && !comment) {
                alert(msgs.errorEmpty);
                return;
            }

            const formData = new FormData();
            formData.append('action', 'thumbfeedback');
            formData.append('title', mw.config.get('wgPageName'));
            formData.append('vote', vote);
            formData.append('comment', comment);
            formData.append('format', 'json');
            formData.append('token', mw.user.tokens.get('csrfToken'));

            fetch(mw.util.wikiScript('api'), { method: 'POST', body: formData })
                .then(res => res.json())
                .then(res => {
                    if (res?.thumbfeedback?.result === 'success') {
                        const popup = $('<div></div>').text(msgs.popupSuccess).css({
                            position: 'fixed',
                            bottom: '80px',
                            left: '50%',
                            transform: 'translateX(-50%)',
                            background: '#4caf50',
                            color: '#fff',
                            padding: '10px 20px',
                            borderRadius: '5px',
                            zIndex: 99999
                        }).appendTo('body');
                        setTimeout(() => popup.remove(), 3000);
                        form[0].reset();
                        $('.thumb').css('background', '');
                    } else {
                        alert(msgs.errorSave);
                        console.log(res);
                    }
                })
                .catch(err => {
                    alert(msgs.errorSave);
                    console.error('Network error:', err);
                });
        });

        // Obsługa kolorowania łapek po wyborze
        $('.thumb input').on('change', function() {
            $('.thumb').css('background', '');
            if ($(this).is(':checked')) {
                if ($(this).val() === '1') {
                    $(this).closest('.thumb').css('background', '#4caf50');
                } else if ($(this).val() === '-1') {
                    $(this).closest('.thumb').css('background', '#f44336');
                }
            }
        });
    });
})(mediaWiki, jQuery);
