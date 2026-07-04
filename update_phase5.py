import sys, os

files_to_process = [
    'resources/views/frontend/transactions/index.blade.php',
    'resources/views/frontend/transactions/show.blade.php',
    'resources/views/frontend/transactions/partials/list.blade.php',
    'resources/views/frontend/profile/edit.blade.php',
    'resources/views/frontend/wishlist/index.blade.php'
]

for filepath in files_to_process:
    if not os.path.exists(filepath):
        continue
    
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # General old pink colors -> css vars
    content = content.replace('#d4a5a5', 'var(--color-primary)')
    content = content.replace('#b5838d', 'var(--color-primary-light)')
    content = content.replace('#fef6f5', 'var(--color-surface-alt)')
    
    # Cart/Wishlist specific
    content = content.replace('#cf7e7e', 'var(--color-primary)')
    content = content.replace('#b76e79', 'var(--color-primary-light)')
    
    # Hero gradients dark
    content = content.replace(
        'background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);',
        'background: linear-gradient(135deg, #111111 0%, #1a1a1a 50%, #2a2a2a 100%);'
    )
    content = content.replace(
        'background: radial-gradient(circle, rgba(207,126,126,0.15) 0%, transparent 70%);',
        'background: radial-gradient(circle, rgba(194,24,91,0.15) 0%, transparent 70%);'
    )
    
    # CSS custom props specific to pages
    content = content.replace('--ck-pink: #d4a5a5;', '--ck-pink: var(--color-primary);')
    content = content.replace('--ck-pink-2: #b5838d;', '--ck-pink-2: var(--color-primary-light);')
    content = content.replace('--ck-soft: #fef6f5;', '--ck-soft: var(--color-surface-alt);')
    content = content.replace('--ck-pink: var(--color-primary);', '--ck-pink: var(--color-primary);') # Avoid double replacement if script ran before
    
    content = content.replace('--pink: var(--color-primary);', '--pink: var(--color-primary);') # Safe fallback
    content = content.replace('--pink-2:#b5838d;', '--pink-2:var(--color-primary-light);')
    content = content.replace('--soft:#fef6f5;', '--soft:var(--color-surface-alt);')
    
    content = content.replace('--tx-pink: #d4a5a5;', '--tx-pink: var(--color-primary);')
    content = content.replace('--tx-pink-2: #b5838d;', '--tx-pink-2: var(--color-primary-light);')
    content = content.replace('--tx-soft: #fef6f5;', '--tx-soft: var(--color-surface-alt);')
    
    # Fonts
    content = content.replace("'Poppins','Inter',system-ui,-apple-system,'Segoe UI',sans-serif", "var(--font-body, 'Montserrat', sans-serif)")
    content = content.replace("'Inter', sans-serif", "var(--font-body, 'Montserrat', sans-serif)")
    
    if 'wishlist/index.blade.php' in filepath:
        content = content.replace(
            ".wl-hero h1 {\n    font-family: var(--font-body, 'Montserrat', sans-serif);\n    font-size: 1.75rem;\n    font-weight: 800;",
            ".wl-hero h1 {\n    font-family: var(--font-heading, 'Cormorant', serif);\n    font-size: 2rem;\n    font-weight: 400;"
        )
        content = content.replace(
            '.wl-hero i { color: var(--color-primary); margin-right: 10px; }',
            '.wl-hero i { color: var(--color-primary); margin-right: 10px; }'
        )
        
    if 'profile/edit.blade.php' in filepath:
        content = content.replace(
            '.prof-avatar-wrap {\n        width: 120px;\n        height: 120px;\n        border-radius: 50%;\n        padding: 4px;\n        background: linear-gradient(135deg, var(--pink), var(--pink-2));',
            '.prof-avatar-wrap {\n        width: 120px;\n        height: 120px;\n        border-radius: 50%;\n        padding: 4px;\n        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));'
        )
        content = content.replace(
            '.nav-pills .nav-link.active {\n        background: var(--pink);',
            '.nav-pills .nav-link.active {\n        background: var(--color-primary);'
        )

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

print('Processed Phase 5 files')
