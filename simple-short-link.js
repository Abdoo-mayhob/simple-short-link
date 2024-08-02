document.addEventListener('DOMContentLoaded', function() {
    const copyButton = document.getElementById('copy-shortlink');
    copyButton.addEventListener('click', function() {
        const copyText = document.getElementById('shortlink');
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand('copy');
    });
});
