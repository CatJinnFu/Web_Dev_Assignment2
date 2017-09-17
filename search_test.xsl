<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:template match="/">
<html>
<body>
<table class="table">
   <thead>
        <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Type</th>
            <th>Brand</th>
            <th>Gender</th>
            <th>Price</th>
        </tr>
  </thead>
  <tbody>
  <xsl:for-each select="clothes/men/item">
    <tr>
       <td>
        
           <img width="100" height="100"><xsl:attribute name="src">img/product_img/<xsl:value-of select="photos/photo_one" />.jpg</xsl:attribute></img>
         
       </td>
         <td><a> <xsl:attribute name="href">detail.html#<xsl:value-of select="Id"/>?<xsl:value-of select="Type" />=<xsl:value-of select="Gender" /></xsl:attribute><xsl:value-of select="product" /></a>
       </td>
       <td>
         <xsl:value-of select="Type" />
       </td>
       <td>
         <xsl:value-of select="brand" />
       </td>
       <td>
       	<xsl:value-of select="Gender" />
       </td>
       <td>
       	<xsl:value-of select="price" />
       </td>
   </tr>                                
  </xsl:for-each>
    <xsl:for-each select="clothes/ladies/item">
    <tr>
       <td>
           <a href="#">
           <img width="100" height="100"><xsl:attribute name="src">img/product_img/<xsl:value-of select="photos/photo_one" />.jpg</xsl:attribute></img>
           </a>
       </td>
         <td><a> <xsl:attribute name="href">detail.html#<xsl:value-of select="Id"/>?<xsl:value-of select="Type" />=<xsl:value-of select="Gender" /></xsl:attribute><xsl:value-of select="product" /></a>
       </td>
        <td>
         <xsl:value-of select="Type" />
       </td>
       <td>
         <xsl:value-of select="brand" />
       </td>
       <td>
       	<xsl:value-of select="Gender" />
       </td>
       <td>
       	<xsl:value-of select="price" />
       </td>
   </tr>                                
  </xsl:for-each>

</tbody>
<tfoot>
  <tr>
         <th colspan="5"></th>
         <th colspan="2"></th>
    </tr>
</tfoot>
                        


</table>
</body>
</html>
</xsl:template>

</xsl:stylesheet>