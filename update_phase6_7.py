import os

files_to_update = [
    'resources/views/frontend/returs/index.blade.php',
    'resources/views/frontend/returs/create.blade.php',
    'resources/views/frontend/returs/show.blade.php',
    'resources/views/frontend/notifications/index.blade.php',
    'resources/views/frontend/vouchers/index.blade.php',
    'resources/views/frontend/ratings/index.blade.php',
    'resources/views/frontend/ratings/create.blade.php',
    'resources/views/frontend/ratings/edit.blade.php',
    
    'resources/views/auth/login.blade.php',
    'resources/views/auth/register.blade.php',
    'resources/views/auth/forgot-password.blade.php',
    'resources/views/auth/reset-password.blade.php',
    'resources/views/auth/verify-email.blade.php',
    'resources/views/auth/confirm-password.blade.php',
    'resources/views/layouts/guest.blade.php'
]

for filepath in files_to_update:
    if not os.path.exists(filepath):
        print('Skipping (not found):', filepath)
        continue
    
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Apply search and replace patterns from fixuiux.md
    content = content.replace('#d4a5a5', 'var(--color-primary)')
    content = content.replace('#b5838d', 'var(--color-primary-light)')
    content = content.replace('#cf7e7e', 'var(--color-primary)')
    content = content.replace('#b76e79', 'var(--color-primary-light)')
    content = content.replace('#fef6f5', 'var(--color-surface-alt)')
    
    content = content.replace("'Poppins'", "'Montserrat'")
    content = content.replace("'Inter'", "'Montserrat'")
    
    content = content.replace('rgba(212, 165, 165,', 'rgba(194, 24, 91,')
    content = content.replace('rgba(212,165,165,', 'rgba(194,24,91,')
    content = content.replace('rgba(207,126,126,', 'rgba(194,24,91,')
    content = content.replace('rgba(181, 131, 141,', 'rgba(233, 30, 140,')
    content = content.replace('rgba(181,131,141,', 'rgba(233,30,140,')
    
    # Hero/Auth dark gradient
    content = content.replace('background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);', 'background: linear-gradient(135deg, #111111 0%, #1a1a1a 50%, #2a2a2a 100%);')
    
    # CSS Custom Properties handling (if they have locally scoped vars)
    content = content.replace('--pink: #d4a5a5;', '--pink: var(--color-primary);')
    content = content.replace('--pink-2:#b5838d;', '--pink-2:var(--color-primary-light);')
    content = content.replace('--soft:#fef6f5;', '--soft:var(--color-surface-alt);')
    
    content = content.replace('--auth-pink: #d4a5a5;', '--auth-pink: var(--color-primary);')
    content = content.replace('--auth-pink-2: #b5838d;', '--auth-pink-2: var(--color-primary-light);')
    content = content.replace('--auth-soft: #fef6f5;', '--auth-soft: var(--color-surface-alt);')
    
    content = content.replace('--ck-pink: #d4a5a5;', '--ck-pink: var(--color-primary);')
    content = content.replace('--ck-pink-2: #b5838d;', '--ck-pink-2: var(--color-primary-light);')
    content = content.replace('--ck-soft: #fef6f5;', '--ck-soft: var(--color-surface-alt);')
    
    content = content.replace('--tx-pink: #d4a5a5;', '--tx-pink: var(--color-primary);')
    content = content.replace('--tx-pink-2: #b5838d;', '--tx-pink-2: var(--color-primary-light);')
    content = content.replace('--tx-soft: #fef6f5;', '--tx-soft: var(--color-surface-alt);')

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print('Updated:', filepath)

print('Phase 6 & 7 colors updated successfully.')
