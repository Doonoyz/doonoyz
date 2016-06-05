/*==============================================================*/
/* Nom de SGBD :  MySQL 5.0                                     */
/* Date de création :  28/07/2008 21:35:02                      */
/*==============================================================*/

CREATE USER 'doonoyz'@'%' IDENTIFIED BY 'kI(_mRFp';

GRANT USAGE ON * . * TO 'doonoyz'@'%' IDENTIFIED BY 'kI(_mRFp' WITH MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0 ;

CREATE DATABASE IF NOT EXISTS `doonoyz` ;

GRANT ALL PRIVILEGES ON `doonoyz` . * TO 'doonoyz'@'%';

USE `doonoyz`;

drop table if exists DN_ADMIN;

drop table if exists DN_BID;

drop table if exists DN_COMMENT;

drop table if exists DN_COMPETENCE;

drop table if exists DN_COMPO;

drop table if exists DN_FOLDER;

drop table if exists DN_CONTACT;

drop table if exists DN_CONTACTTYPE;

drop table if exists DN_EVENT;

drop table if exists DN_GROUP;

drop table if exists DN_GROUPCOMP;

drop table if exists DN_GROUPSTYLE;

drop table if exists DN_LABEL;

drop table if exists DN_MOSTAPPRECIATED;

drop table if exists DN_MP;

drop table if exists DN_NEWS;

drop table if exists DN_NOTE;

drop table if exists DN_STYLEMUSIC;

drop table if exists DN_USERINGROUP;

drop table if exists DN_ADMINTASK;



/*==============================================================*/
/* Table : DN_ADMIN                                             */
/*==============================================================*/
create table DN_ADMIN
(
   USER_ID              bigint not null,
   primary key (USER_ID)
);

/*==============================================================*/
/* Table : DN_BID                                               */
/*==============================================================*/
create table DN_BID
(
   BID_ID               bigint not null,
   VOTINGUSER_ID        bigint not null,
   BID_VALUE            tinyint(1),
   primary key (BID_ID, VOTINGUSER_ID)
);

/*==============================================================*/
/* Table : DN_COMMENT                                           */
/*==============================================================*/
create table DN_COMMENT
(
   COMMENT_ID           bigint not null AUTO_INCREMENT,
   COMMENT_BODY         longtext,
   COMMENT_TYPE         enum('compo', 'news', 'blog'),
   COMMENT_ACTIVE       tinyint(1),
   COMMENT_TYPE_ID      bigint,
   COMMENT_DATE         timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   USER_ID              bigint,
   primary key (COMMENT_ID)
);

/*==============================================================*/
/* Table : DN_COMPETENCE                                        */
/*==============================================================*/
create table DN_COMPETENCE
(
   COMPETENCE_ID        bigint not null AUTO_INCREMENT,
   COMPETENCE_NAME      mediumtext,
   COMPETENCE_ACTIVE    tinyint(1),
   primary key (COMPETENCE_ID)
);

/*==============================================================*/
/* Table : DN_COMPO                                             */
/*==============================================================*/
create table DN_COMPO
(
   COMPO_ID             bigint not null AUTO_INCREMENT,
   FOLDER_ID            bigint,
   GROUP_ID             bigint,
   COMPO_NAME           mediumtext,
   COMPO_FILE           mediumtext,
   COMPO_TYPE           enum('music', 'picture', 'text', 'video'),
   COMPO_FETCHED        enum('Y', 'N', 'C', 'E') NOT NULL DEFAULT 'N',
   COMPO_PUBLIC         tinyint(1),
   COMPO_ORIGINAL_EXT   VARCHAR( 5 ) NOT NULL ,
   COMPO_VIEWS			BIGINT( 20 ) NOT NULL DEFAULT '0' ,
   COMPO_DELETED        TINYINT( 1 ) NOT NULL ,
   COMPO_CREATION       TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   primary key (COMPO_ID)
);

/*==============================================================*/
/* Table : DN_FOLDER                                            */
/*==============================================================*/
create table DN_FOLDER
(
   FOLDER_ID            bigint not null AUTO_INCREMENT,
   GROUP_ID             bigint,
   FOLDER_NAME          mediumtext,
   FOLDER_PUBLIC        tinyint(1),
   primary key (FOLDER_ID)
);

/*==============================================================*/
/* Table : DN_CONTACT                                           */
/*==============================================================*/
create table DN_CONTACT
(
   CONTACT_ID           bigint not null AUTO_INCREMENT,
   CONTACTTYPE_ID       bigint,
   GROUP_ID             bigint,
   CONTACT_VALUE        mediumtext,
   primary key (CONTACT_ID)
);

/*==============================================================*/
/* Table : DN_CONTACTTYPE                                       */
/*==============================================================*/
create table DN_CONTACTTYPE
(
   CONTACTTYPE_ID       bigint not null AUTO_INCREMENT,
   CONTACTTYPE_NAME     mediumtext,
   CONTACTTYPE_PATTERN  mediumtext,
   CONTACTTYPE_ACTIVE   tinyint(1),
   CONTACTTYPE_FILTER   mediumtext,
   CONTACTTYPE_LOGO     mediumtext,
   primary key (CONTACTTYPE_ID)
);

/*==============================================================*/
/* Table : DN_EVENT                                             */
/*==============================================================*/
create table DN_EVENT
(
   EVENT_ID             bigint not null AUTO_INCREMENT,
   GROUP_ID             bigint,
   EVENT_TITLE          mediumtext,
   EVENT_DESCRIPTION    longtext,
   EVENT_DATE           timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   primary key (EVENT_ID)
);

/*==============================================================*/
/* Table : DN_GROUP                                             */
/*==============================================================*/
create table DN_GROUP
(
   GROUP_ID                     bigint not null AUTO_INCREMENT,
   GROUP_PAYS                   mediumtext,
   GROUP_LIEU                   mediumtext,
   GROUP_POSTAL                 mediumtext,
   GROUP_NOM                    mediumtext,
   GROUP_DESCRIPTION            longtext,
   GROUP_ACTIVE                 tinyint(1),
   GROUP_CENSURE                enum('0', '10', '12', '16', '18', '21'),
   GROUP_FULL                   tinyint(1),
   GROUP_ADMIN                  bigint,
   LABEL_ID                  	bigint NOT NULL DEFAULT '0' ,
   GROUP_LONG                   float,
   GROUP_LAT                    float,
   GROUP_URL                    mediumtext,
   GROUP_LOCATION_PROCESSED	    tinyint(1),
   GROUP_DATE_CREATION		    timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   GROUP_DATE_DELETE		    timestamp,
   primary key (GROUP_ID)
);

/*==============================================================*/
/* Table : DN_GROUPCOMP                                         */
/*==============================================================*/
create table DN_GROUPCOMP
(
   COMPETENCE_ID        bigint,
   USER_ID              bigint,
   GROUP_ID             bigint
);

/*==============================================================*/
/* Table : DN_GROUPSTYLE                                        */
/*==============================================================*/
create table DN_GROUPSTYLE
(
   STYLE_ID             bigint,
   GROUP_ID             bigint
);

/*==============================================================*/
/* Table : DN_LABEL			                                    */
/*==============================================================*/
create table DN_LABEL
(
   LABEL_ID             bigint not null AUTO_INCREMENT,
   LABEL_NAME 			mediumtext,
   LABEL_ACTIVE         tinyint(1),
   primary key (LABEL_ID)
);

/*==============================================================*/
/* Table : DN_MOSTAPPRECIATED                                   */
/*==============================================================*/
create table DN_MOSTAPPRECIATED
(
   GROUP_ID             bigint,
   MA_ORDER             bigint
);

/*==============================================================*/
/* Table : DN_MP                                                */
/*==============================================================*/
create table DN_MP
(
   MP_ID                bigint not null AUTO_INCREMENT,
   MP_TITLE             mediumtext,
   MP_BODY              longtext,
   USER_ID_SENDER       bigint,
   USER_ID_RECEIVER     bigint,
   MP_DATE              timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   MP_READ              tinyint(1),
   primary key (MP_ID)
);

/*==============================================================*/
/* Table : DN_NEWS                                              */
/*==============================================================*/
create table DN_NEWS
(
   NEWS_ID              bigint not null AUTO_INCREMENT,
   GROUP_ID             bigint,
   NEWS_TITLE           mediumtext,
   NEWS_BODY            longtext,
   primary key (NEWS_ID)
);

/*==============================================================*/
/* Table : DN_NOTE                                              */
/*==============================================================*/
create table DN_NOTE
(
   COMPO_ID             bigint,
   NOTE_VALUE           enum('1','2','3','4','5','6','7','8','9','10'),
   USER_ID              bigint
);

/*==============================================================*/
/* Table : DN_STYLEMUSIC                                        */
/*==============================================================*/
create table DN_STYLEMUSIC
(
   STYLE_ID             bigint not null AUTO_INCREMENT,
   STYLE_NAME           mediumtext,
   STYLE_ACTIVE         tinyint(1),
   primary key (STYLE_ID)
);

/*==============================================================*/
/* Table : DN_USERINGROUP                                       */
/*==============================================================*/
create table DN_USERINGROUP
(
   GROUP_ID             bigint,
   USER_ID              bigint,
   USER_NAME            mediumtext,
   INGROUP_ACTIVE       tinyint(1),
   BID_ID               bigint
);

/*==============================================================*/
/* Table : DN_ADMINTASK                                         */
/*==============================================================*/
CREATE TABLE DN_ADMINTASK
(
    TASK_ID             BIGINT NOT NULL AUTO_INCREMENT,
    TASK_MESSAGE_ID     BIGINT NOT NULL ,
    TASK_MESSAGE_ARGS   LONGTEXT NOT NULL ,
    TASK_COMPONENT_NAME MEDIUMTEXT NOT NULL ,
    TASK_COMPONENT_ID   BIGINT NOT NULL ,
    TASK_REPORTER_ID    BIGINT NOT NULL , 
    TASK_ASSIGNED_ID    BIGINT , 
    primary key (TASK_ID)
);


alter table DN_COMPO add constraint FK_REFERENCE_4 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

alter table DN_COMPO add constraint FK_REFERENCE_21 foreign key (FOLDER_ID)
      references DN_FOLDER (FOLDER_ID) on delete restrict on update restrict;

alter table DN_CONTACT add constraint FK_REFERENCE_19 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

alter table DN_FOLDER add constraint FK_REFERENCE_20 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

alter table DN_CONTACT add constraint FK_REFERENCE_7 foreign key (CONTACTTYPE_ID)
      references DN_CONTACTTYPE (CONTACTTYPE_ID) on delete restrict on update restrict;

alter table DN_EVENT add constraint FK_REFERENCE_14 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

alter table DN_GROUPCOMP add constraint FK_REFERENCE_10 foreign key (COMPETENCE_ID)
      references DN_COMPETENCE (COMPETENCE_ID) on delete restrict on update restrict;

alter table DN_GROUPCOMP add constraint FK_REFERENCE_15 foreign key (USER_ID)
      references DN_USERINGROUP (USER_ID) on delete restrict on update restrict;

alter table DN_GROUPCOMP add constraint FK_REFERENCE_18 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

alter table DN_GROUPSTYLE add constraint FK_REFERENCE_5 foreign key (STYLE_ID)
      references DN_STYLEMUSIC (STYLE_ID) on delete restrict on update restrict;

alter table DN_GROUPSTYLE add constraint FK_REFERENCE_6 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

alter table DN_MOSTAPPRECIATED add constraint FK_REFERENCE_12 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

alter table DN_NEWS add constraint FK_REFERENCE_16 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

alter table DN_NOTE add constraint FK_REFERENCE_13 foreign key (COMPO_ID)
      references DN_COMPO (COMPO_ID) on delete restrict on update restrict;

alter table DN_USERINGROUP add constraint FK_REFERENCE_1 foreign key (GROUP_ID)
      references DN_GROUP (GROUP_ID) on delete restrict on update restrict;

