BEGIN
declare nombreEquipe int default 0;
set nombreEquipe = (Select count(*) From equipe where idEntraineur=New.idEntraineur);
    IF nombreEquipe>3
      THEN
       delete from equipe where idEntraineur=new.idEntraineur and idEquipe=new.idEquipe;
    END IF;
END

