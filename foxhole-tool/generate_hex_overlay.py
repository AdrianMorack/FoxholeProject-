#!/usr/bin/env python3
import xml.etree.ElementTree as ET

# Parse the SVG
tree = ET.parse('public/images/InteractMap.svg')
root = tree.getroot()

# Find all path elements with IDs ending in "Hex"
paths = []
for elem in root.iter('{http://www.w3.org/2000/svg}path'):
    elem_id = elem.get('id', '')
    if elem_id.endswith('Hex'):
        d = elem.get('d', '')
        transform = elem.get('transform', '')
        display_name = elem_id.replace('Hex', '')
        paths.append({
            'id': elem_id,
            'display_name': display_name,
            'd': d,
            'transform': transform
        })

# Sort by ID for consistency
paths.sort(key=lambda x: x['id'])

# Generate Blade template
output_lines = []
output_lines.append('            <!-- SVG Overlay for Interactive Hexes -->')
output_lines.append('            <svg class="absolute inset-0 w-full h-full" viewBox="0 0 2560 1554" preserveAspectRatio="xMidYMid meet" style="z-index: 10;">')

for p in paths:
    output_lines.append(f'                <!-- {p["id"]} -->')
    output_lines.append(f'                <a href="{{{{ route(\'map-viewer\', [\'shard\' => session(\'foxhole_shard\', \'baker\'), \'mapName\' => \'{p["id"]}\']) }}}}"')
    output_lines.append(f'                   class="hex-link">')
    output_lines.append(f'                    <path')
    output_lines.append(f'                       class="hex-region"')
    output_lines.append(f'                       d="{p["d"]}"')
    if p['transform']:
        output_lines.append(f'                       transform="{p["transform"]}"')
    output_lines.append(f'                    >')
    output_lines.append(f'                        <title>{p["display_name"]}</title>')
    output_lines.append(f'                    </path>')
    output_lines.append(f'                </a>')
    output_lines.append(f'                ')

output_lines.append('            </svg>')

# Write to file
with open('hex_overlay_generated.txt', 'w') as f:
    f.write('\n'.join(output_lines))

print(f"✓ Generated Blade template for {len(paths)} hexes")
print(f"✓ Output written to hex_overlay_generated.txt")
print(f"✓ Total lines: {len(output_lines)}")
