DELIMITER //
CREATE PROCEDURE InsertEtudiantsGP2()
BEGIN
  DECLARE i INT DEFAULT 1;
  DECLARE j INT DEFAULT 1;
  
  WHILE i <= 50 DO
    INSERT INTO `users`(`cin`, `name`, `status`, `role`, `password`, `email`, `filliere`, `annee_scolaire`, `genre`)
    VALUES
      (CONCAT('GP2', LPAD(i, 3, '0')), CONCAT(j, '-GP2'), 'externe', 'student', NULL, CONCAT(j, '-GP2@gmail.com'), 'Génie de procédé', '2', IF(i % 2 = 0, 'girl', 'boy'));

    SET i = i + 1;
    SET j = j + 1;
  END WHILE;
END //
DELIMITER ;

CALL InsertEtudiantsGP2();