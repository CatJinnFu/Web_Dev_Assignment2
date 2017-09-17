import re

f = open("Products.txt", "r")
w = open("clothes.xml", "w")

gender = "male"

type = ""


w.write("""<?xml version="1.0" encoding="ISO-8859-1"?>\n""")
#w.write("""<?xml-stylesheet type="text/xsl" href="clothes.xsl"?>\n""")
w.write("<clothes>\n")



for line in f:
	 
    matchObj = re.match( r'Product:', line, re.M|re.I)

    if(line.strip() == "Men:"):
        w.write("<men>\n")
        gender = "male"

    if(line.strip() == "Ladies:"):
        gender = "woman"
        w.write("</men>\n")
        w.write("<ladies>\n")

    if(line.strip() == "T-shirts:"):
    	type =  "T-shirt"	
 	
    if(line.strip() == "Pants:"):
        type =  "Pants"
 	    	    	   
    if(line.strip() == "Shirts:"):
        type =  "Shirt"

    if(line.strip() == "Accessories:"):
        type =  "Accessories"        	
 	      

    t = line.strip()

    if(t.strip('.').isdigit()):
        w.write("<item>\n")
        w.write("  <type>"+type+"</type>\n")
        w.write("  <type_meta></type_meta>\n")
        w.write("  <id> "+ line.strip() + "</id>\n")
        id = line.strip().strip('.')

    matchObj = re.match( r'Product:', line, re.M|re.I)

    if(matchObj):
	    w.write("  <product>  " + line[8:].strip() + "  </product>\n")		

    matchObj = re.match( r'Brand:', line, re.M|re.I)
    if(matchObj):
	    w.write("  <brand>" + line[6:].strip() + "</brand>\n")

    matchObj = re.match( r'Price:', line, re.M|re.I)
    if(matchObj):
	    w.write("  <price>  " + line[6:].strip() + "  </price>\n")

    matchObj = re.match( r'Product details', line, re.M|re.I)
    if(matchObj):
        w.write("  <details>")
        line = f.readline()
        #while((line != "Product details") | (line != "Materials & care")):
        w.write("  " +line.strip())
        w.write("  </details>\n")

    matchObj = re.match( r'Material & care', line, re.M|re.I)
    if(matchObj):
        w.write("  <material>")
        matchObj = re.match( r'Size & Fit', line, re.M|re.I)
        while(matchObj == None):
        	line = f.readline()
        	matchObj = re.match( r'Size & Fit', line, re.M|re.I)
        	if(matchObj == None):
	           w.write("  " +line.strip())

        w.write("  </material>\n")

    if(matchObj):
        w.write("  <size>")
        matchObj = re.match( r'Define style', line, re.M|re.I)
        while(matchObj == None):
        	line = f.readline()
        	matchObj = re.match( r'Define style', line, re.M|re.I)
        	if(matchObj == None):
	           w.write("" + line.strip())

        w.write(" </size>\n")     

    if(matchObj):
        w.write("  <description>")
        matchObj = re.match( r'Define style', line, re.M|re.I)
        w.write("" +line.strip())
        w.write("</description>\n <photos>\n")
        if((gender.strip() == "male") & (type.strip() == "T-shirt")):
            w.write("  <photo_one>" + "men_tshirts_"+ id + "_small</photo_one>\n")
            w.write("  <photo_two>" + "men_tshirts_"+ id + "_large</photo_two>\n")
        if((gender.strip() == "male") & (type.strip() == "Shirt")):
            w.write("  <photo_one>" + "men_shirts_"+ id + "_small</photo_one>\n")
            w.write("  <photo_two>" + "men_shirts_"+ id + "_large</photo_two>\n")
        if((gender.strip() == "male") & (type.strip() == "Pants")):
            w.write("  <photo_one>" + "men_pants_"+ id + "_front</photo_one>\n")
            w.write("  <photo_two>" + "men_pants_"+ id + "_back</photo_two>\n")
        if((gender.strip() == "male") & (type.strip() == "Accessories")):
            w.write("  <photo_one>" + "men_acc_"+ id + "_picA </photo_one>\n")
            w.write("  <photo_two>" + "men_acc_"+ id + "_picB </photo_two>\n")	 
        if((gender.strip() == "woman") & (type.strip() == "T-shirt")):
            w.write("  <photo_one>" + "ladies_tshirt_"+ id + "_front</photo_one>\n")
            w.write("  <photo_two>" + "ladies_tshirt_"+ id + "_back</photo_two>\n")
        if((gender.strip() == "woman") & (type.strip() == "Shirt")):
            w.write("  <photo_one>" + "ladies_shirts_"+ id + "_front</photo_one>\n")
            w.write("  <photo_two>" + "ladies_shirts_"+ id + "_back</photo_two>\n")
        if((gender.strip() == "woman") & (type.strip() == "Pants")):
            w.write("  <photo_one>" + "ladies_pants_"+ id + "_front</photo_one>\n")
            w.write("  <photo_two>" + "ladies_pants_"+ id + "_back</photo_two>\n") 
        if((gender.strip() == "woman") & (type.strip() == "Accessories")):
            w.write("  <photo_one>" + "ladies_acc_"+ id + "_picA</photo_one>\n")
            w.write("  <photo_two>" + "ladies_acc_"+ id + "_picB</photo_two>\n")
        w.write(" </photos>\n</item>\n")

w.write("</ladies>\n")
w.write("</clothes>")  