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
                        <div class="d-flex justify-content-center">
                            <h1>
                                <xsl:value-of select="name"/>
                            </h1>
                        </div>

                        <div class="d-flex justify-content-center bg-secondary text-light">
                            <h3>Χρήστες</h3>
                        </div>

                        <div class="table-responsive mx-3 mt-3">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
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
                        </div>

                        <div class="d-flex justify-content-center bg-secondary text-light">
                            <h3>Λίστες εργασιών</h3>
                        </div>

                        <div class="row row-cols-1 row-cols-md-2 g-4 mt-3 mx-2 mb-3">
                            <xls:for-each select="taskslists/taskslist">

                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="d-flex">
                                                <h4>
                                                    <xsl:value-of select="tittle"/>
                                                </h4>
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

                                        <div class="card-body">
                                            <ul>
                                                <xls:for-each select="tasks/task">
                                                    <li>
                                                        <xsl:value-of select="title"/>
                                                    </li>
                                                </xls:for-each>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </xls:for-each>
                        </div>
                    </div>

                    <hr/>
                </xls:for-each>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
