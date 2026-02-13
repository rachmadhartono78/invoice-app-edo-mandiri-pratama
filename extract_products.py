import xml.etree.ElementTree as ET
import json
import re

def parse_shared_strings(path):
    tree = ET.parse(path)
    root = tree.getroot()
    xmlns = '{http://schemas.openxmlformats.org/spreadsheetml/2006/main}'
    strings = []
    for si in root.findall(f'{xmlns}si'):
        text = ''
        # Text can be in <t> or inside <r><t>
        for t in si.findall(f'{xmlns}t'):
            if t.text: text += t.text
        for r in si.findall(f'{xmlns}r'):
            for t in r.findall(f'{xmlns}t'):
                if t.text: text += t.text
        strings.append(text)
    return strings

def parse_worksheet(path, shared_strings):
    tree = ET.parse(path)
    root = tree.getroot()
    xmlns = '{http://schemas.openxmlformats.org/spreadsheetml/2006/main}'
    
    rows_data = []
    
    sheet_data = root.find(f'{xmlns}sheetData')
    for row in sheet_data.findall(f'{xmlns}row'):
        row_cells = {}
        for c in row.findall(f'{xmlns}c'):
            r = c.get('r') # Cell address e.g. A1
            t = c.get('t') # Type (s = shared string)
            v = c.find(f'{xmlns}v')
            
            value = None
            if v is not None:
                val_text = v.text
                if t == 's':
                    idx = int(val_text)
                    if idx < len(shared_strings):
                        value = shared_strings[idx]
                else:
                    value = val_text
            
            # Extract column letter
            match = re.match(r"([A-Z]+)([0-9]+)", r)
            if match:
                col = match.group(1)
                row_cells[col] = value
        
        if row_cells:
            rows_data.append(row_cells)
            
    return rows_data

def clean_price(price_str):
    if not price_str: return 0
    try:
        return float(price_str)
    except:
        return 0

def extract_products(rows):
    products = []
    current_category = "General"
    
    # Based on inspection:
    # Col B: Item Name
    # Col C: Dimensions/Description
    # Col D: Price (Numeric in XML, not shared string usually)
    
    for row in rows:
        # Check if it's a category header (often just text in the first few cols/merged)
        # But based on the shared strings we saw "AREA DATANG BARANG", "AREA MASAK" etc.
        # Let's try to identify product lines.
        
        name = row.get('B')
        dims = row.get('C')
        price = row.get('D')
        
        if not name:
            # Check if Column A has a category?
            possible_cat = row.get('A') # Or maybe it's in a shared string in A that I missed?
            # From XML view:
            # Row 13: A=29 (index 29 -> "AREA MASAK"?? No index 29 is "16" wait.)
            # Shared strings:
            # 7: AREA DATANG BARANG
            # 16: AREA CUCI OMPRENG
            # 33: GUDANG KERING & ALAT
            # 39: AREA GUDANG BASAH
            # 53: AREA MASAK
            # 62: AREA PERSIAPAN
            # 66: AREA PEMORSIAN
            # ...
            
            # Let's check if A contains one of these known categories from shared keys?
            # Actually, manually listing them based on the observed data:
            continue

        # If price looks like a number
        if price:
            try:
                price_val = float(price)
                if price_val > 0:
                   products.append({
                       'name': name,
                       'description': dims,
                       'price': price_val,
                       'category': current_category # Logic for category is weak currently
                   })
            except:
                pass
                
    return products

# Main execution
shared_strings = parse_shared_strings('temp_xlsx/xl/sharedStrings.xml')
rows = parse_worksheet('temp_xlsx/xl/worksheets/sheet1.xml', shared_strings)

products = extract_products(rows)

# Refine categories by spotting headers in the rows flow? 
# or just dump all products for now.
# Analyzing the previous sharedStrings output:
# 7: AREA DATANG BARANG
# 16: AREA CUCI OMPRENG
# ...

# Let's try a smarter pass to catch categories
# Only lines where B is populated AND D is populated are likely products.
# Lines where ONLY A is populated might be categories?

final_products = []
current_cat = "Uncategorized"

for row in rows:
    # Is it a category?
    # In the XML inspection, `row r="7"` had `c r="B7"` with val 17 ("Timbangan 150kg").
    # `row r="7"` also had `c r="A7" s="29" t="s"`. Value was index 16 ("AREA CUCI OMPRENG"). 
    # WAIT. Row 7 contained "Triple Sink" (idx 17 is "Triple Sink"?? No wait.)
    # Shared strings:
    # 0: PRICELIST...
    # 7: AREA DATANG BARANG
    # 8: Timbangan 150kg
    # ...
    # 17: Triple Sink
    
    # XML `sheet1.xml` Inspection:
    # Row 7: A7(s=16="AREA CUCI OMPRENG"? NO. Shared Strings list is 0-indexed.)
    # Let's re-read the sharedStrings.xml snippet carefully.
    
    # 0: PRICELIST
    # ...
    # 13: AREA ...? No
    # <si><t>AREA</t></si> is index 13?
    # <si><t>ALAT</t></si>
    # <si><t>Dimensi(mm)</t></si>
    # <si><t>HARGA</t></si>
    
    # 17: AREA DATANG BARANG
    # 18: Timbangan 150kg
    
    # Okay my manual indexing was a guess. Let's trust the script to map indices correctly.
    
    # Check for category in Column A (often column A has the numbering or category in merged cells)
    # In XML provided:
    # Row 7: A7(t=s, v=16). If shared_strings[16] is "AREA CUCI OMPRENG", then row 7 STARTS that category?
    # But row 7 also has B7(v=17 -> "Triple Sink") and D7(v=4000000).
    # So Row 7 is a product, but A7 indicates the category for THIS row (and maybe subsequent ones?).
    
    cat_candidate_idx = row.get('A')
    if cat_candidate_idx:
        # It's an index into shared strings if t="s" was extracted by parse_worksheet
        # My parse_worksheet handles the lookup.
        current_cat = row.get('A')

    name = row.get('B')
    dims = row.get('C')
    price_val = row.get('D')
    
    if name and price_val:
        try:
            p = float(price_val)
            if p > 100: # Filter out small numbers/garbage
                final_products.append({
                    'name': name.strip(),
                    'description': dims.strip() if dims else "",
                    'price': p,
                    'category': current_cat, # Use the A column value if present, else previous?
                    # Ideally we'd persist the category if A is empty.
                    # But if A has a number (1, 2, 3...) it's just numbering.
                    # "AREA..." strings are categories.
                })
        except:
            pass

# Post-processing: Filter out simple numbering from categories
real_products = []
last_valid_cat = "General"

for p in final_products:
    cat = p['category']
    # If category seems to be just a number (it might be represented as text "1", "2"), ignore update
    if isinstance(cat, str) and (cat.upper().startswith("AREA") or cat.upper().startswith("GUDANG") or cat.upper().startswith("PELENGKAP")):
        last_valid_cat = cat
    
    p['category'] = last_valid_cat
    real_products.append(p)

print(json.dumps(real_products, indent=2))
