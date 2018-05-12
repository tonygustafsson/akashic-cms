(function () {
    document.addEventListener('FormCreated', () => {
        var rangeSliders = document.querySelectorAll('input[type=range]');

        rangeSliders.forEach(slider => {
            slider.addEventListener('input', (e) => {
                // On sliding the range slider
                let infoDiv = document.getElementById(`range-value-${slider.id}`);
                infoDiv.innerHTML = `${e.target.value}/${e.target.max}`;
            });
        });
    });
})();