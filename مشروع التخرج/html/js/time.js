const data = {
    'it': {
        name: "Information Technology Program",
        logo: "img/itclub.png",
        years: ["المستوى الأول", "المستوى الثاني", "المستوى الثالث - Network", "المستوى الثالث - Software", "المستوى الرابع - Network", "المستوى الرابع - Software", "Academy Students"]
    },
    'railway': {
        name: "Railway Technology Program",
        logo: "img/railway-icon.png",
        years: ["المستوى الأول", "المستوى الثاني"]
    }
};

function handleProgramChange() {
    const program = document.getElementById('programSelect').value;
    const yearSelect = document.getElementById('yearSelect');
    const logoImg = document.getElementById('programLogo');
    const title = document.getElementById('programTitle');

    if (data[program]) {
        // تحديث القائمة
        yearSelect.innerHTML = '<option value="">Select a Study year</option>';
        data[program].years.forEach(yr => {
            yearSelect.add(new Option(yr, yr));
        });

        // تحديث الصورة والنص
        logoImg.src = data[program].logo;
        title.innerText = data[program].name;
    }
}

// تشغيل الوظيفة تلقائياً عند تحميل الصفحة لإظهار بيانات الـ IT
window.onload = function() {
    handleProgramChange();
};