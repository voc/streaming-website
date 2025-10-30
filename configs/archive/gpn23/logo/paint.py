#!/usr/bin/env python3

import json

logo = {'7,5,1': True, '6,5,2': True, '7,5,0': True, '6,5,1': True, '6,5,3': True, '5,5,2': True, '6,5,0': True, '5,5,1': True, '5,5,3': True, '5,5,0': True, '4,5,2': True, '4,5,3': True, '5,4,2': True, '5,4,0': True, '5,4,1': True, '5,4,3': True, '5,3,1': True, '5,3,0': True, '4,3,2': True, '4,3,1': True, '4,3,0': True, '4,3,3': True, '3,3,2': True, '3,3,1': True, '3,4,3': True, '3,4,2': True, '3,4,1': True, '3,4,0': True, '3,5,3': True, '3,5,2': True, '4,5,0': True, '4,5,1': True, '5,6,3': True, '5,6,0': True, '5,6,2': True, '5,6,1': True, '5,7,3': True, '5,7,0': True, '4,7,2': True, '4,7,3': True, '4,7,1': True, '4,7,0': True, '3,7,2': True, '3,7,1': True, '10,3,0': True, '10,4,0': True, '10,4,3': True, '10,3,1': True, '11,3,1': True, '11,3,2': True, '11,4,3': True, '11,4,2': True, '13,3,0': True, '13,3,1': True, '13,4,3': True, '13,4,2': True, '15,3,0': True, '15,4,0': True, '15,4,3': True, '15,3,1': True, '17,3,0': True, '17,4,0': True, '17,4,3': True, '17,3,1': True, '19,3,0': True, '19,3,3': True, '19,4,0': True, '19,4,3': True, '21,3,0': True, '21,3,1': True, '21,4,3': True, '21,4,2': True, '22,3,0': True, '22,3,1': True, '22,4,3': True, '22,4,2': True, '10,6,0': True, '10,7,0': True, '10,7,3': True, '10,6,1': True, '11,6,0': True, '11,6,3': True, '13,7,0': True, '13,7,3': True, '13,6,1': True, '13,6,2': True, '14,6,0': True, '14,6,1': True, '14,7,3': True, '14,7,2': True, '16,6,3': True, '17,6,3': True, '17,6,0': True, '16,6,2': True, '17,7,0': True, '17,7,1': True, '19,6,3': True, '20,6,3': True, '20,6,0': True, '19,6,2': True, '20,7,0': True, '20,7,1': True, '22,6,0': True, '22,6,3': True, '22,7,0': True, '22,7,3': True, '24,6,3': True, '24,6,0': True, '24,7,0': True, '24,7,1': True, '26,6,0': True, '26,6,1': True, '26,7,3': True, '26,7,2': True, '27,6,0': True, '27,6,1': True, '27,7,3': True, '27,7,2': True, '29,6,1': True, '29,6,2': True, '30,6,0': True, '30,6,3': True, '30,7,3': True, '30,7,0': True, '29,7,2': True, '29,7,1': True}

new = {}
new['paintSurface'] = {}
new['whiteColors'] = False
new['enableGrain'] = True
new['enableGradient'] = True
new['enableCA'] = True
new['enableBackground'] = True
new['squareSize'] = 36

# values chosen to be seemless
new['width'] = 2017
new['height'] = 577

open("background.json", "w").write(json.dumps(new))

new['enableBackground'] = False
new['enableGrain'] = False
new['width'] = new['squareSize'] * 31
new['height'] = new['squareSize'] * 8

for k, v in logo.items():
    if not v: continue
    x, y, d = k.split(",")
    x = int(x)
    y = int(y)
    #x += 3
    #y += 3
    new['paintSurface']['%d,%d,%s' % (x, y, d)] = True

open("foreground.json", "w").write(json.dumps(new))




