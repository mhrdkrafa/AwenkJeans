const fs = require('fs');
const path = require('path');

const viewsDir = path.join(__dirname, 'resources', 'views');

const directoriesToScan = [
    'admin',
    'kasir',
    'pelanggan',
    'products',
    'profile',
    'components' // since breeze components might have indigo
];

const regexMap = [
    { regex: /bg-indigo-600/g, replacement: 'bg-[#E85D40]' },
    { regex: /hover:bg-indigo-700/g, replacement: 'hover:bg-orange-600' },
    { regex: /text-indigo-600/g, replacement: 'text-[#E85D40]' },
    { regex: /hover:text-indigo-800/g, replacement: 'hover:text-orange-700' },
    { regex: /hover:text-indigo-900/g, replacement: 'hover:text-orange-800' },
    { regex: /ring-indigo-500/g, replacement: 'ring-[#E85D40]' },
    { regex: /border-indigo-500/g, replacement: 'border-[#E85D40]' },
    { regex: /focus:ring-indigo-500/g, replacement: 'focus:ring-[#E85D40]' },
    { regex: /focus:border-indigo-500/g, replacement: 'focus:border-[#E85D40]' },
    { regex: /bg-\[\#003B95\]/g, replacement: 'bg-[#E85D40]' },
    { regex: /text-\[\#003B95\]/g, replacement: 'text-[#E85D40]' },
    { regex: /hover:bg-blue-800/g, replacement: 'hover:bg-orange-600' },
    { regex: /bg-blue-100/g, replacement: 'bg-orange-100' },
    { regex: /text-blue-800/g, replacement: 'text-orange-800' },
    { regex: /text-blue-600/g, replacement: 'text-[#E85D40]' },
    { regex: /hover:text-blue-900/g, replacement: 'hover:text-orange-700' },
    { regex: /bg-blue-600/g, replacement: 'bg-[#E85D40]' },
    { regex: /bg-blue-500/g, replacement: 'bg-[#E85D40]' },
    { regex: /hover:bg-blue-700/g, replacement: 'hover:bg-orange-600' },
    { regex: /hover:bg-blue-600/g, replacement: 'hover:bg-orange-500' },
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

console.log('Migration completed.');
