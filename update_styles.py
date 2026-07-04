import sys

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Colors
    content = content.replace('#d4a5a5', 'var(--color-primary)')
    content = content.replace('#b5838d', 'var(--color-primary-light)')
    content = content.replace('#fef6f5', 'var(--color-surface-alt)')
    content = content.replace('#fdf5f3', 'var(--color-surface-alt)')
    
    # Specifics for index.blade.php
    content = content.replace("'Poppins', 'Inter', -apple-system, sans-serif;", "var(--font-body, 'Montserrat', sans-serif);")
    
    # Fonts for titles
    if 'index.blade.php' in filepath:
        content = content.replace(
            '.section-title {\n    font-size: 2rem;\n    font-weight: 300;',
            '.section-title {\n    font-family: var(--font-heading, \'Cormorant\', serif);\n    font-size: 2rem;\n    font-weight: 400;'
        )
        content = content.replace(
            '.promo-section-title {\n    font-size: 2rem;\n    font-weight: 300;',
            '.promo-section-title {\n    font-family: var(--font-heading, \'Cormorant\', serif);\n    font-size: 2rem;\n    font-weight: 400;'
        )
        content = content.replace(
            'background: #ff4444;',
            'background: linear-gradient(135deg, #DC2626, #EF4444);'
        )
        content = content.replace(
            'color: #ff4444;',
            'color: var(--color-primary);'
        )
    
    if 'show.blade.php' in filepath:
        content = content.replace(
            "font-family: 'Poppins', 'Inter', sans-serif;",
            "font-family: var(--font-body, 'Montserrat', sans-serif);"
        )
        content = content.replace(
            '.pd-title {\n    font-size: 2.5rem;\n    font-weight: 800;',
            '.pd-title {\n    font-family: var(--font-heading, \'Cormorant\', serif);\n    font-size: 2.5rem;\n    font-weight: 400;'
        )
        
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

process_file('resources/views/frontend/products/index.blade.php')
process_file('resources/views/frontend/products/show.blade.php')

print('Processed index.blade.php and show.blade.php')
