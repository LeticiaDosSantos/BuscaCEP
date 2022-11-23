CREATE DATABASE BuscaCEP CHARACTER SET utf8 COLLATE utf8_general_ci;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `ceps` (
  `id` int(11) NOT NULL,
  `cep` int(8) NOT NULL,
  `logradouro` varchar(400) NOT NULL,
  `complemento` varchar(240) DEFAULT NULL,
  `bairro` varchar(240) NOT NULL,
  `localidade` varchar(240) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `ibge` int(7) NOT NULL,
  `gia` int(4) DEFAULT NULL,
  `ddd` int(2) NOT NULL,
  `siafi` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `ceps`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ceps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

