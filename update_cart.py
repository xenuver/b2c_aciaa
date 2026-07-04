import sys, os

files_to_process = [
    'resources/views/frontend/cart/index.blade.php',
    'resources/views/frontend/checkout/index.blade.php',
    'resources/views/frontend/checkout/direct.blade.php',
    'resources/views/frontend/checkout/success.blade.php'
]

for filepath in files_to_process:
    if not os.path.exists(filepath):
        continue
    
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Generic Replacements for all files
    content = content.replace('#cf7e7e', 'var(--color-primary)')
    content = content.replace('#b76e79', 'var(--color-primary-light)')
    content = content.replace("'Inter', sans-serif", "var(--font-body, 'Montserrat', sans-serif)")
    
    # Hero gradient adjustment
    content = content.replace(
        'background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);',
        'background: linear-gradient(135deg, #111111 0%, #1a1a1a 50%, #2a2a2a 100%);'
    )
    content = content.replace(
        'background: radial-gradient(circle, rgba(207,126,126,0.15) 0%, transparent 70%);',
        'background: radial-gradient(circle, rgba(194,24,91,0.15) 0%, transparent 70%);'
    )
    
    # Specifics for Cart
    if 'cart/index.blade.php' in filepath:
        content = content.replace(
            ".cart-hero h1 {\n    font-family: var(--font-body, 'Montserrat', sans-serif);\n    font-size: 1.75rem;\n    font-weight: 800;",
            ".cart-hero h1 {\n    font-family: var(--font-heading, 'Cormorant', serif);\n    font-size: 2rem;\n    font-weight: 400;"
        )
        content = content.replace(
            '.qty-stepper .qty-btn:hover { background: #ebe6e1; }',
            '.qty-stepper .qty-btn:hover { background: var(--color-surface-alt); color: var(--color-primary); }'
        )
        content = content.replace(
            'background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);',
            'background: linear-gradient(135deg, #C2185B 0%, #E91E8C 100%);'
        )
        content = content.replace(
            '.summary-card {\n    background: #fff;\n    border-radius: 16px;\n    box-shadow: 0 4px 24px rgba(0,0,0,0.06);\n    border: 1px solid rgba(0,0,0,0.04);',
            '.summary-card {\n    background: rgba(255,255,255,0.9);\n    backdrop-filter: blur(10px);\n    border-radius: 16px;\n    box-shadow: 0 4px 24px rgba(0,0,0,0.06);\n    border: 1px solid rgba(255,255,255,0.2);'
        )
        content = content.replace(
            '.btn-continue {\n    display: flex;',
            '.btn-continue {\n    border: 1.5px solid var(--color-primary);\n    color: var(--color-primary);\n    display: flex;'
        )
        content = content.replace(
            '.cart-empty i { color: #e5e7eb;',
            '.cart-empty i { color: var(--color-primary);'
        )
        
    if 'checkout/index.blade.php' in filepath or 'checkout/direct.blade.php' in filepath:
        content = content.replace(
            '.checkout-hero h1 {\n    font-family: var(--font-body, \'Montserrat\', sans-serif);\n    font-size: 1.75rem;\n    font-weight: 800;',
            '.checkout-hero h1 {\n    font-family: var(--font-heading, \'Cormorant\', serif);\n    font-size: 2rem;\n    font-weight: 400;'
        )
        content = content.replace(
            '.address-card.selected {\n    border-color: var(--color-primary);\n    background: #fdf5f5;',
            '.address-card.selected {\n    border-color: var(--color-primary);\n    background: var(--color-surface-alt);'
        )
        content = content.replace(
            'background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);',
            'background: linear-gradient(135deg, #CA8A04 0%, #EAB308 100%);'
        )
        
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)

print('Processed cart and checkout files')
