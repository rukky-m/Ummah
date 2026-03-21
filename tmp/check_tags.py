import re

def check_blade_tags(file_path):
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()

    tags = re.findall(r'@(if|else|elseif|endif|can|endcan|auth|endauth|guest|endguest|php|endphp|while|endwhile|foreach|endforeach|for|endfor|section|endsection|hasSection|elseHasSection|yield|extends|include|component|endcomponent)', content)
    
    stack = []
    pairs = {
        'if': 'endif',
        'can': 'endcan',
        'auth': 'endauth',
        'guest': 'endguest',
        'php': 'endphp',
        'while': 'endwhile',
        'foreach': 'endforeach',
        'for': 'endfor',
        'component': 'endcomponent',
        'section': 'endsection'
    }
    
    # These don't open or close
    standalone = ['else', 'elseif', 'yield', 'extends', 'include', 'hasSection', 'elseHasSection']
    
    line_nums = []
    # Find tags with line numbers
    for i, line in enumerate(content.split('\n')):
        found = re.findall(r'@(if|else|elseif|endif|can|endcan|auth|endauth|guest|endguest|php|endphp|while|endwhile|foreach|endforeach|for|endfor|section|endsection|hasSection|elseHasSection|yield|extends|include|component|endcomponent)', line)
        for t in found:
            line_nums.append((t, i + 1))

    for tag, line in line_nums:
        if tag in pairs:
            stack.append((tag, line))
        elif tag in pairs.values():
            if not stack:
                print(f"Error: Found @{tag} at line {line} with no opening tag.")
                return
            opening, opening_line = stack.pop()
            if pairs[opening] != tag:
                print(f"Error: Mismatched tag. Found @{tag} at line {line}, expected @{pairs[opening]} for @{opening} at line {opening_line}.")
                return
    
    if stack:
        for tag, line in stack:
            print(f"Error: Unclosed @{tag} starting at line {line}.")
    else:
        print("No blade tag issues found.")

print("Checking navigation.blade.php:")
check_blade_tags(r'c:\xampp\htdocs\ummah\resources\views\layouts\navigation.blade.php')
print("\nChecking admin/loans/show.blade.php:")
check_blade_tags(r'c:\xampp\htdocs\ummah\resources\views\admin\loans\show.blade.php')
