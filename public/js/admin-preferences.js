(function () {
    const translations = {
        'Portfolio Admin': 'អ្នកគ្រប់គ្រង Portfolio', 'MAIN MENU': 'ម៉ឺនុយចម្បង',
        'Dashboard': 'ផ្ទាំងគ្រប់គ្រង', 'About': 'អំពីខ្ញុំ', 'Contact': 'ទំនាក់ទំនង',
        'Projects': 'គម្រោង', 'Skills': 'ជំនាញ', 'Services': 'សេវាកម្ម',
        'Education': 'ការអប់រំ', 'Experience': 'បទពិសោធន៍', 'View Portfolio': 'មើល Portfolio',
        'Logout': 'ចាកចេញ', 'Create new': 'បង្កើតថ្មី', 'Add new': 'បន្ថែមថ្មី',
        'Save': 'រក្សាទុក', 'Update': 'កែប្រែ', 'Edit': 'កែសម្រួល', 'Delete': 'លុប',
        'Cancel': 'បោះបង់', 'Actions': 'សកម្មភាព', 'Status': 'ស្ថានភាព',
        'Title': 'ចំណងជើង', 'Description': 'ការពិពណ៌នា', 'Name': 'ឈ្មោះ',
        'Email': 'អ៊ីមែល', 'Message': 'សារ', 'Messages': 'សារ',
        'Back to Dashboard': 'ត្រឡប់ទៅផ្ទាំងគ្រប់គ្រង', 'No records found.': 'រកមិនឃើញទិន្នន័យទេ។'
    };

    function translatePage() {
        if ((localStorage.getItem('admin-language') || 'en') !== 'km') return;
        document.documentElement.lang = 'km';
        const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
        const nodes = [];
        while (walker.nextNode()) nodes.push(walker.currentNode);
        nodes.forEach((node) => {
            const value = node.nodeValue.trim();
            if (translations[value]) node.nodeValue = node.nodeValue.replace(value, translations[value]);
        });
    }

    function addPicker() {
        if (document.getElementById('language-km')) return;
        const picker = document.createElement('div');
        picker.style.cssText = 'position:fixed;right:18px;bottom:18px;z-index:9999;display:flex;gap:4px;padding:4px;border:1px solid #cbd5e1;border-radius:12px;background:#fff;box-shadow:0 10px 30px #0f172a26';
        picker.innerHTML = '<button type="button" data-lang="en">EN</button><button type="button" data-lang="km">ខ្មែរ</button>';
        const current = localStorage.getItem('admin-language') || 'en';
        picker.querySelectorAll('button').forEach((button) => {
            const active = button.dataset.lang === current;
            button.style.cssText = `border:0;border-radius:8px;padding:8px 10px;cursor:pointer;font-weight:700;color:${active ? '#fff' : '#475569'};background:${active ? '#4f46e5' : 'transparent'}`;
            button.addEventListener('click', () => {
                localStorage.setItem('admin-language', button.dataset.lang);
                window.location.reload();
            });
        });
        document.body.appendChild(picker);
    }

    document.addEventListener('DOMContentLoaded', () => { translatePage(); addPicker(); });
})();
