<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:param name="type" />

<xsl:output method="html"/>
<xsl:template match="/">

  <html>
  <body>
    <div class="form-group">

      <div class="checkbox">
             <label>
        <input type="checkbox" id="Armani" onclick="loadXMLDoc('clothes.xml',loadItems,'men','none');" /> Armani 

        (<xsl:value-of select="count(/clothes/men/item[brand='Armani' and type = $type])"/>)
       
      </label>  
        </div> 
   
        <div class="checkbox">
             <label>
        <input type="checkbox" id="Versace" onclick="loadXMLDoc('clothes.xml',loadItems,'men','none')" /> Versace (<xsl:value-of select="count(/clothes/men/item[brand='Versace' and type = $type])"/>)
      </label>  
        </div> 
        <div class="checkbox">
             <label>
        <input type="checkbox" id="Carlo" onclick="loadXMLDoc('clothes.xml',loadItems,'men','none')" /> Carlo Bruni (<xsl:value-of select="count(/clothes/men/item[brand='Carlo Bruni' and type = $type])"/>)
      </label>  
        </div>   
      <div class="checkbox">
             <label>
        <input type="checkbox" id="Jack" onclick="loadXMLDoc('clothes.xml',loadItems,'men','none')" /> Jack Honey (<xsl:value-of select="count(/clothes/men/item[brand='Jack Honey' and type = $type])"/>)
      </label>  
        </div>      
                                         
    </div>
  </body>
  </html>

</xsl:template>

</xsl:stylesheet>

