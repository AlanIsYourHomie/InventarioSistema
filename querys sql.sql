
--select * from PERSONA
----

create PROCEDURE sp_mant_persona
    @proceso CHAR(1),
    @idpersona int,
    @iddistrito int,
    @nombres VARCHAR(40),
    @apematerno VARCHAR(30),
    @apepaterno VARCHAR(30),
    @dni CHAR(8),
    @direccion NVARCHAR(50),
    @celar CHAR(9),
    @fecnac date,
    @correo varchar(40),
    @estado CHAR(1)
as
BEGIN
    if @proceso = 'N'
                BEGIN
        insert into Persona
            (IDDISTRITO, NOMBRES,APEPATERNO, APEMATERNO, DNI, DIRECCION, CELULAR, FECNAC, CORREO, ESTADO)
        VALUES
            (@iddistrito, @nombres, @apepaterno, @apematerno, @dni, @direccion, @celar, @fecnac, @correo, @estado)
    END
    if @proceso='U'
                BEGIN
        update PERSONA SET
                            IDDISTRITO = @iddistrito,
                            NOMBRES = @nombres,
                            APEPATERNO = @apepaterno,
                            APEMATERNO = @apematerno,
                            DNI = @dni,
                            DIRECCION = @direccion,
                            CELULAR = @celar,
                            FECNAC = @fecnac,
                            CORREO = @correo,
                            ESTADO = @estado
                            where IDPERSONA = @idpersona
    END
    if @proceso = 'D'
            BEGIN
        update PERSONA SET
                    ESTADO = 0
                WHERE IDPERSONA = @idpersona
    END
    if @proceso = 'E'
            BEGIN
        delete from CLIENTE
                where
        DELETE from PERSONA
                where IDPERSONA=@idpersona
    END
END

EXECUTE sp_mant_persona 'E','73','120','alan','tacilla','ramos','71853120','waza','960474006','2004-01-30','luis@gmail.com', '1'