document.addEventListener("DOMContentLoaded", function () {
    const downloadBtn = document.getElementById("download");
    const invoice = document.getElementById("invoice");

    if (downloadBtn && invoice) {
        downloadBtn.addEventListener("click", function () {
            const opt = {
                margin: 1,
                filename: 'receipt.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            html2pdf().from(invoice).set(opt).save();
        });
    } else {
        console.error("Download button or invoice not found!");
    }
});