<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:xls="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <html>
            <head>
                <title>Ομάδες χρηστών
                </title>
                <style>

                </style>
            </head>
            <body>
                <h1>Ομάδες χρηστών</h1>

                <xls:for-each select="/teams/team">
                    <div class="team">
                        <h1>
                            <xsl:value-of select="name"/>
                        </h1>
                    </div>
                </xls:for-each>

            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
