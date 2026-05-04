document.addEventListener('DOMContentLoaded', function () {

    // ===================== TOGGLE PASSWORD VISIBILITY ===================== //
    function toggleVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (!input || !icon) return;

        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('ki-eye-slash');
        icon.classList.toggle('ki-eye');
    }

    document.getElementById('togglePassword')?.addEventListener('click', function () {
        toggleVisibility('password', 'eyeIcon');
    });

    document.getElementById('togglePasswordConfirm')?.addEventListener('click', function () {
        toggleVisibility('passwordConfirm', 'eyeIconConfirm');
    });

    // ===================== PASSWORD STRENGTH METER ===================== //
    const meters = [
        document.getElementById('meter1'),
        document.getElementById('meter2'),
        document.getElementById('meter3'),
        document.getElementById('meter4'),
    ];

    const colors = {
        1: '#F1416C', // merah - lemah
        2: '#FFC700', // kuning - sedang
        3: '#50CD89', // hijau muda - kuat
        4: '#009EF7', // biru - sangat kuat
    };

    function getStrength(password) {
        let score = 0;
        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        return score;
    }

    function updateMeter(strength) {
        meters.forEach(function (meter, index) {
            if (index < strength) {
                meter.style.background = colors[strength];
            } else {
                meter.style.background = '#E4E6EF';
            }
        });
    }

    document.getElementById('password')?.addEventListener('input', function () {
        const strength = getStrength(this.value);
        updateMeter(this.value.length === 0 ? 0 : strength);
        checkPasswordMatch();
    });

    // ===================== PASSWORD MATCH CHECKER ===================== //
    const matchInfo = document.getElementById('passwordMatchInfo');

    function checkPasswordMatch() {
        const pass = document.getElementById('password')?.value;
        const confirm = document.getElementById('passwordConfirm')?.value;

        if (!confirm) {
            matchInfo.textContent = '';
            return;
        }

        if (pass === confirm) {
            matchInfo.textContent = '✓ Password cocok';
            matchInfo.style.color = '#50CD89';
        } else {
            matchInfo.textContent = '✗ Password tidak cocok';
            matchInfo.style.color = '#F1416C';
        }
    }

    document.getElementById('passwordConfirm')?.addEventListener('input', checkPasswordMatch);

    // ===================== NIP — ANGKA SAJA ===================== //
    document.querySelector('input[name="nip"]')?.addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

});