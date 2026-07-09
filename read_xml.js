import fs from 'fs';

const xmlContent = fs.readFileSync('word/document.xml', 'utf-8');

// Regex to match paragraph tags <w:p>...</w:p>
// and then extract all text elements <w:t>...</w:t> inside them
const pRegex = /<w:p\b[^>]*>([\s\S]*?)<\/w:p>/g;
const tRegex = /<w:t\b[^>]*>([^<]*?)<\/w:t>/g;

let match;
const paragraphs = [];

while ((match = pRegex.exec(xmlContent)) !== null) {
    const pContent = match[1];
    let tMatch;
    let pText = "";
    while ((tMatch = tRegex.exec(pContent)) !== null) {
        pText += tMatch[1];
    }
    if (pText.trim()) {
        paragraphs.push(pText.trim());
    }
}

// Write the paragraphs to a file
fs.writeFileSync('extracted_docx_text.txt', paragraphs.join('\n\n'), 'utf-8');
console.log(`Successfully extracted ${paragraphs.length} paragraphs to extracted_docx_text.txt`);
