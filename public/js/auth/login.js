document.addEventListener('DOMContentLoaded', function () {

    let selectedTahun = parseInt(document.getElementById('tahunAnggaranInput').value);

    function updateDropdownUI(tahun) {
        document.getElementById('selectedTahunLabel').textContent = 'Tahun Anggaran ' + tahun;
        document.getElementById('tahunAnggaranInput').value = tahun;

        document.querySelectorAll('.tahun-option').forEach(function (opt) {
            const isActive = parseInt(opt.dataset.tahun) === tahun;
            const iconBox = opt.querySelector('.tahun-icon-box');
            const icon = opt.querySelector('.ki-calendar');
            const label = opt.querySelector('.tahun-label');
            const sublabel = opt.querySelector('.tahun-sublabel');
            const bullet = opt.querySelector('.tahun-bullet');

            if (isActive) {
                opt.style.background = 'var(--bs-primary)';
                iconBox.style.background = 'rgba(255,255,255,0.2)';
                icon.style.color = '#fff';
                label.style.color = '#fff';
                sublabel.style.color = 'rgba(255,255,255,0.75)';
                bullet.style.background = '#fff';
            } else {
                opt.style.background = '';
                iconBox.style.background = '#F1F3FF';
                icon.style.color = 'var(--bs-primary)';
                label.style.color = '';
                sublabel.style.color = '';
                bullet.style.background = '#A1A5B7';
            }
        });
    }

    // Init default
    updateDropdownUI(selectedTahun);

    document.querySelectorAll('.tahun-option').forEach(function (el) {

        el.addEventListener('click', function () {
            selectedTahun = parseInt(this.dataset.tahun);
            updateDropdownUI(selectedTahun);

            const trigger = document.getElementById('tahunDropdown');
            const ddInstance = bootstrap.Dropdown.getOrCreateInstance(trigger);
            ddInstance.hide();
        });

        el.addEventListener('mouseenter', function () {
            if (parseInt(this.dataset.tahun) !== selectedTahun) {
                this.style.background = '#F5F8FF';
            }
        });

        el.addEventListener('mouseleave', function () {
            if (parseInt(this.dataset.tahun) !== selectedTahun) {
                this.style.background = '';
            }
        });
    });
});