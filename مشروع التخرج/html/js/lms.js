document.addEventListener("DOMContentLoaded", () => {
    // 1. بندور على العنصر اللي جواه نص "MAIN MENU" عشان نخلي هو الزرار
    const allTitles = document.querySelectorAll("h2, h3, div, span, p"); // بندور في كل الاحتمالات
    let menuToggleBtn = null;

    for (let el of allTitles) {
        if (el.textContent.trim() === "MAIN MENU") {
            menuToggleBtn = el;
            break; // لقيناه!
        }
    }

    // 2. بنحدد القائمة الجانبية بالكلاس اللي عندك (sidebar-on أو sidebar)
    const sidebar = document.querySelector(".sidebar-on") || document.querySelector(".sidebar");

    // 3. تشغيل الحركة السحرية لما تضغط
    if (menuToggleBtn && sidebar) {
        // بنخلي الماوس يقلب إيد لما يقف على الكلمة عشان يبان إنه زرار
        menuToggleBtn.style.cursor = "pointer"; 
        
        menuToggleBtn.addEventListener("click", () => {
            // لو القائمة ظاهرة بنخفيها، ولو مخفية بنظهرها
            if (sidebar.style.display === "none") {
                sidebar.style.display = "block";
            } else {
                sidebar.style.display = "none";
            }
        });
    }
});