CREATE TABLE player (
  player_id int(11) NOT NULL auto_increment,
  name varchar(35) NOT NULL default '',
  dob date default NULL,
  nationality varchar(30) default NULL,
  height int(11) default NULL,
  handedness enum('left','right') default 'right',
  speciality enum('allrounder','batsman','wicketkeeper','bowler-seam-fast') default NULL,
  details varchar(255) default NULL,
  photo blob,
  PRIMARY KEY  (player_id)
) TYPE=InnoDB;