document.addEventListener('DOMContentLoaded', () => {
    console.log('DOMContentLoaded');

    const selectButtons = document.querySelectorAll('#uni_select');
    const uniCount = document.getElementById('uni_count');

    let selectedUniArr = [];

    for (let index = 0; index < selectButtons.length; index++) {
        selectButtons[index].addEventListener('click', () => {
            // check for duplicate
            if (selectedUniArr.includes(selectButtons[index].value)) {
                alert('You have already selected this university');
                return;
            }

            selectedUniArr.push(selectButtons[index].value);

            if (selectedUniArr.length > 0) {
                const clearButton = document.getElementById('clear_button');

                uniCount.innerText = `${selectedUniArr.length}`;
                clearButton.style.display = 'block';

                clearButton.onclick = () => {
                    selectedUniArr = [];
                    clearButton.style.display = 'none';
                };
            }

            if (selectedUniArr.length > 2) {
                window.location.href = `comparison.php?ids=${selectedUniArr.join(',')}`;
            }
        });
    }




});