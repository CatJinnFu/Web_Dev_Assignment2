<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:template match="/">
 <html>
  <body>
<thead>
     <tr>
       <th colspan="2">Image</th>
       <th>Product</th>
       <th>Brand</th>
       <th>Gender</th>
       <th>Price</th>
     </tr>
</thead>
<tbody>
<tbody>
  <xsl:for-each select="clothing/men/item">
    <tr>
       <td>
           <a href="#">
           <img><xsl:attribute name="src">/img/product_img/<xsl:value-of select="clothing/men/item/photos/photo_one" />.jpg</xsl:attribute></img>
           </a>
       </td>
         <td><a href="detail.html"><xsl:value-of select="clothing/men/item/product" /></a>
       </td>
       <td>
         <xsl:value-of select="clothing/men/item/brand" />
       </td>
       <td>
       	<xsl:value-of select="clothing/men/item/Gender" />
       </td>
       <td>
       	<xsl:value-of select="clothing/men/item/Price" />
       </td>
   </tr>                                
  </xsl:for-each>

    <xsl:for-each select="clothing/ladies/item">
    <tr>
       <td>
           <a href="#">
           <img><xsl:attribute name="src">/img/product_img/<xsl:value-of select="clothing/ladies/item/photos/photo_one" />.jpg</xsl:attribute></img>
           </a>
       </td>
         <td><a href="detail.html"><xsl:value-of select="clothing/ladies/item/product" /></a>
       </td>
       <td>
         <xsl:value-of select="clothing/ladies/item/brand" />
       </td>
       <td>
       	<xsl:value-of select="clothing/ladies/item/Gender" />
       </td>
       <td>
       	<xsl:value-of select="clothing/ladies/item/Price" />
       </td>
   </tr>                                
  </xsl:for-each>

</tbody>
                              
                                       
<tfoot>
<tr>                                       
</tr>
</tfoot>

</table>
  </body>
  </html>

</xsl:template>

</xsl:stylesheet>