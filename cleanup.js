import fs from 'fs';

const files = [
    'read_docx.py',
    'upload_docx.html',
    'read_xml.js',
    'extracted_docx_text.txt'
];

files.forEach(f => {
    try {
        if (fs.existsSync(f)) {
            fs.unlinkSync(f);
            console.log(`Deleted ${f}`);
        }
    } catch (e) {
        console.error(`Error deleting ${f}: ${e.message}`);
    }
});

try {
    if (fs.existsSync('word/document.xml')) {
        fs.unlinkSync('word/document.xml');
        console.log('Deleted word/document.xml');
    }
    if (fs.existsSync('word')) {
        fs.rmdirSync('word');
        console.log('Deleted word folder');
    }
} catch (e) {
    console.error(`Error deleting word folder: ${e.message}`);
}
