<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:xls="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <html>
            <head>
                <title>Ομάδες χρηστών</title>

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
                      crossorigin="anonymous"/>

            </head>
            <body>
                <xls:for-each select="/teams/team">
                    <div class="team">
                        <h1>
                            <xsl:value-of select="name"/>
                        </h1>

                        <div class="d-flex justify-content-center bg-secondary text-light">
                            <h3>Χρήστες</h3>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>username</th>
                                    <th>Όνομα χρήστη</th>
                                    <th>Email</th>
                                </tr>
                            </thead>

                            <tbody>
                                <xls:for-each select="users/user">
                                    <tr>
                                        <td>
                                            <xsl:value-of select="username"/>
                                        </td>
                                        <td>
                                            <xsl:value-of select="name"/>
                                        </td>
                                        <td>
                                            <xsl:value-of select="email"/>
                                        </td>
                                    </tr>
                                </xls:for-each>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center bg-secondary text-light">
                            <h3>Λίστες εργασιών</h3>
                        </div>

                        <xls:for-each select="taskslists/taskslist">
                            <div>
                                <div class="d-flex">
                                    <h3> : : : <xsl:value-of select="tittle"/></h3>
                                    <span class="badge bg-primary mx-3 my-auto">
                                        <xsl:value-of select="status"/>
                                    </span>
                                </div>

                                <div>
                                    <span class="badge bg-secondary">
                                        <xsl:value-of select="category"/>
                                    </span>
                                </div>
                            </div>

                            <h4>Εργασίες</h4>

                            <ul>
                                <xls:for-each select="tasks/task">
                                    <li>
                                        <xsl:value-of select="title"/>
                                    </li>
                                </xls:for-each>
                            </ul>
                        </xls:for-each>
                    </div>
                </xls:for-each>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
