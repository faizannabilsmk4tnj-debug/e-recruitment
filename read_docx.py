import zipfile
import xml.etree.ElementTree as ET
import os

def read_docx(file_path):
    # Namespace for Word processing ML
    namespaces = {
        'w': 'http://schemas.openxmlformats.org/wordprocessingml/2006/main'
    }
    
    if not os.path.exists(file_path):
        print(f"File not found: {file_path}")
        return
        
    try:
        with zipfile.ZipFile(file_path) as docx:
            # Read document.xml
            xml_content = docx.read('word/document.xml')
            root = ET.fromstring(xml_content)
            
            # Extract paragraphs
            text_lines = []
            for para in root.iter('{http://schemas.openxmlformats.org/wordprocessingml/2006/main}p'):
                # Extract text inside run elements
                runs = para.findall('.//{http://schemas.openxmlformats.org/wordprocessingml/2006/main}t', namespaces)
                para_text = "".join([t.text for t in runs if t.text])
                if para_text.strip():
                    text_lines.append(para_text)
            
            # Let's save the extracted text to a text file for analysis
            output_file = "extracted_docx_text.txt"
            with open(output_file, "w", encoding="utf-8") as f:
                f.write("\n".join(text_lines))
            print(f"Extracted {len(text_lines)} paragraphs. Saved to {output_file}")
            
    except Exception as e:
        print(f"Error reading docx: {e}")

if __name__ == "__main__":
    docx_path = "skppl 212 pbl trpl hampir finale mantebb.docx"
    read_docx(docx_path)
