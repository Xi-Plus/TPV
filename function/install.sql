CREATE TABLE `tpv` (
  `fbid` char(15) NOT NULL,
  `fbname` char(30) NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `token` char(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `tpv`
  ADD UNIQUE KEY `token` (`token`);
