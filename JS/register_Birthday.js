$(document).ready(function () {
    
    let currentYear = new Date().getFullYear();
    for (let i = currentYear; i >= 1900; i--) {  // 今年到1900年排列
        $("#year").append($("<option>", { value: i, text: i }));
    }

    function generateDays(month) {
        let daysInMonth  = new Date(currentYear, month, 0).getDate();
        for (let i = 1; i <= daysInMonth; i++) {
            $("#day").append($("<option>", { value: i, text: i }));
        }
    }

    $("#month").change(function () {
        var selectedMonth = $(this).val();
        generateDays(selectedMonth);
    });
});