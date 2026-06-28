const fs = require('fs');
const path = require('path');

const targetDirs = [
    'c:/AwenkJeans/resources/views/admin',
    'c:/AwenkJeans/resources/views/kasir',
    'c:/AwenkJeans/resources/views/pelanggan',
    'c:/AwenkJeans/resources/views/pos',
    'c:/AwenkJeans/resources/views/profile',
    'c:/AwenkJeans/resources/views/layouts'
];

const replacements = [
    // Backgrounds
    { from: /\bbg-slate-100\b/g, to: 'bg-[#1a1a1a]' },
    { from: /\bbg-slate-50\b/g, to: 'bg-[#1a1a1a]' },
    { from: /\bbg-gray-100\b/g, to: 'bg-[#1a1a1a]' },
    { from: /\bbg-white\b/g, to: 'bg-[#222]' },
    { from: /\bbg-white\/90\b/g, to: 'bg-[#222]/90' },
    
    // Text colors
    { from: /\btext-slate-900\b/g, to: 'text-white' },
    { from: /\btext-slate-800\b/g, to: 'text-white' },
    { from: /\btext-gray-900\b/g, to: 'text-white' },
    { from: /\btext-gray-800\b/g, to: 'text-white' },
    { from: /\btext-slate-700\b/g, to: 'text-slate-300' },
    { from: /\btext-gray-700\b/g, to: 'text-slate-300' },
    { from: /\btext-slate-600\b/g, to: 'text-slate-400' },
    { from: /\btext-gray-600\b/g, to: 'text-slate-400' },
    { from: /\btext-slate-500\b/g, to: 'text-slate-400' },
    { from: /\btext-gray-500\b/g, to: 'text-slate-400' },
    
    // Borders
    { from: /\bborder-slate-200\b/g, to: 'border-white/10' },
    { from: /\bborder-slate-300\b/g, to: 'border-white/10' },
    { from: /\bborder-gray-200\b/g, to: 'border-white/10' },
    { from: /\bborder-gray-300\b/g, to: 'border-white/10' },
    { from: /\bborder-slate-100\b/g, to: 'border-white/5' },
    { from: /\bdivide-slate-200\b/g, to: 'divide-white/10' },
    { from: /\bdivide-gray-200\b/g, to: 'divide-white/10' },

    // Primary Brand Colors (Blue -> Orange)
    { from: /\bbg-blue-600\b/g, to: 'bg-[#E85D40]' },
    { from: /\bbg-blue-700\b/g, to: 'bg-orange-600' },
    { from: /\bhover:bg-blue-700\b/g, to: 'hover:bg-orange-600' },
    { from: /\bhover:bg-blue-800\b/g, to: 'hover:bg-orange-600' },
    { from: /\btext-blue-600\b/g, to: 'text-[#E85D40]' },
    { from: /\btext-blue-700\b/g, to: 'text-[#E85D40]' },
    { from: /\bhover:text-blue-700\b/g, to: 'hover:text-white' },
    { from: /\bbg-\[\#003B95\]\b/g, to: 'bg-[#E85D40]' },
    { from: /\btext-\[\#003B95\]\b/g, to: 'text-[#E85D40]' },
    { from: /\bbg-indigo-600\b/g, to: 'bg-[#E85D40]' },
    { from: /\bbg-indigo-500\b/g, to: 'bg-[#E85D40]' },
    { from: /\btext-indigo-600\b/g, to: 'text-[#E85D40]' },
    { from: /\bring-indigo-500\b/g, to: 'ring-[#E85D40]' },
    { from: /\bborder-indigo-500\b/g, to: 'border-[#E85D40]' },
    { from: /\bfocus:border-indigo-500\b/g, to: 'focus:border-[#E85D40]' },
    { from: /\bfocus:ring-indigo-500\b/g, to: 'focus:ring-[#E85D40]' },
    { from: /\bbg-blue-50\/30\b/g, to: 'bg-[#1a1a1a]' }, // Kasir background
    
    // Hover states
    { from: /\bhover:bg-slate-50\b/g, to: 'hover:bg-[#1a1a1a]' },
    { from: /\bhover:bg-slate-100\b/g, to: 'hover:bg-[#1a1a1a]' },
    { from: /\bhover:bg-gray-50\b/g, to: 'hover:bg-[#1a1a1a]' },
];

function processDirectory(dirPath) {
    if (!fs.existsSync(dirPath)) return;
    const files = fs.readdirSync(dirPath);
    
    files.forEach(file => {
        const fullPath = path.join(dirPath, file);
        const stat = fs.statSync(fullPath);
        
        if (stat.isDirectory()) {
            processDirectory(fullPath);
        } else if (file.endsWith('.blade.php')) {
            // Skip the public catalog views which are already themed correctly
            if (fullPath.replace(/\\/g, '/').includes('catalog/') || fullPath.replace(/\\/g, '/').includes('welcome.blade.php')) {
                return;
            }
            if (fullPath.replace(/\\/g, '/').includes('layouts/app.blade.php') || fullPath.replace(/\\/g, '/').includes('layouts/guest.blade.php') || fullPath.replace(/\\/g, '/').includes('layouts/navigation.blade.php')) {
                return; // Already done
            }
            
            let content = fs.readFileSync(fullPath, 'utf8');
            let modified = false;
            
            replacements.forEach(r => {
                if (r.from.test(content)) {
                    content = content.replace(r.from, r.to);
                    modified = true;
                }
            });
            
            if (modified) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log(`Updated: ${fullPath}`);
            }
        }
    });
}

targetDirs.forEach(dir => processDirectory(dir));
console.log("Migration complete.");
