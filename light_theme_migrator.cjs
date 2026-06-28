const fs = require('fs');
const path = require('path');

const viewsDir = path.join(__dirname, 'resources', 'views');

const directoriesToScan = [
    'admin',
    'kasir'
];

const regexMap = [
    // Backgrounds
    { regex: /bg-\[\#1a1a1a\]/g, replacement: 'bg-slate-50' },
    { regex: /bg-\[\#222\]/g, replacement: 'bg-white' },
    { regex: /bg-\[\#141414\]/g, replacement: 'bg-slate-100' },
    
    // Accents (Orange Blossom -> Denim Blue / Leather Amber)
    { regex: /bg-\[\#E85D40\]/g, replacement: 'bg-[#1D4ED8]' }, // Primary Button/Badge to Blue
    { regex: /text-\[\#E85D40\]/g, replacement: 'text-[#1D4ED8]' }, 
    { regex: /border-\[\#E85D40\]/g, replacement: 'border-[#1D4ED8]' }, 
    { regex: /ring-\[\#E85D40\]/g, replacement: 'ring-[#1D4ED8]' }, 
    { regex: /shadow-\[\#E85D40\]/g, replacement: 'shadow-[#1D4ED8]' }, 
    { regex: /shadow-orange-950/g, replacement: 'shadow-blue-950' },
    { regex: /shadow-orange-600/g, replacement: 'shadow-blue-600' },
    
    // Borders
    { regex: /border-white\/5/g, replacement: 'border-slate-200' },
    { regex: /border-white\/10/g, replacement: 'border-slate-200' },
    { regex: /border-white\/20/g, replacement: 'border-slate-300' },
    
    // Text colors
    { regex: /text-white/g, replacement: 'text-slate-900' },
    { regex: /text-slate-300/g, replacement: 'text-slate-600' },
    { regex: /text-slate-400/g, replacement: 'text-slate-500' },
    
    // Hover states
    { regex: /hover:text-white/g, replacement: 'hover:text-slate-900' },
    { regex: /hover:bg-\[\#222\]\/5/g, replacement: 'hover:bg-slate-50' },
    { regex: /bg-\[\#222\]\/10/g, replacement: 'bg-slate-100' },
    { regex: /bg-\[\#222\]\/5/g, replacement: 'bg-slate-50' },
    { regex: /hover:bg-white\/5/g, replacement: 'hover:bg-slate-50' },
    { regex: /hover:bg-white\/10/g, replacement: 'hover:bg-slate-100' },
    { regex: /hover:bg-\[\#1a1a1a\]/g, replacement: 'hover:bg-slate-50' },
    { regex: /hover:bg-\[\#1a1a1a\]\/50/g, replacement: 'hover:bg-slate-50' },
    
    // Transparencies
    { regex: /bg-white\/5/g, replacement: 'bg-slate-50' },
    { regex: /bg-white\/10/g, replacement: 'bg-slate-100' },
];

function processDirectory(dirPath) {
    if (!fs.existsSync(dirPath)) return;
    
    const files = fs.readdirSync(dirPath);
    for (const file of files) {
        const fullPath = path.join(dirPath, file);
        const stat = fs.statSync(fullPath);
        
        if (stat.isDirectory()) {
            processDirectory(fullPath);
        } else if (stat.isFile() && fullPath.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let modified = false;
            
            for (const { regex, replacement } of regexMap) {
                if (regex.test(content)) {
                    content = content.replace(regex, replacement);
                    modified = true;
                }
            }
            
            if (modified) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log(`Updated: ${fullPath.replace(__dirname, '')}`);
            }
        }
    }
}

directoriesToScan.forEach(dir => {
    processDirectory(path.join(viewsDir, dir));
});

console.log('Recursive light theme migration completed.');
