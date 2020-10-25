CREATE TABLE bxnotepad_note (
    id          INT(10)      NOT NULL AUTO_INCREMENT,
    fid         MEDIUMINT(5) NOT NULL DEFAULT '0',
    uid         MEDIUMINT(5) NOT NULL DEFAULT '0',
    update_date INT(10)      NOT NULL DEFAULT '0',
    public      TINYINT(1)   NOT NULL DEFAULT '0',
    priority    TINYINT(2)   NOT NULL DEFAULT '2',
    title       VARCHAR(255) NOT NULL DEFAULT '',
    contents    TEXT         NOT NULL DEFAULT '',
    PRIMARY KEY (id)
)
    ENGINE = ISAM;

CREATE TABLE bxnotepad_folder (
    fid      INT(10)      NOT NULL AUTO_INCREMENT,
    uid      MEDIUMINT(5) NOT NULL DEFAULT '0',
    priority TINYINT(2)   NOT NULL DEFAULT '2',
    name     VARCHAR(64)  NOT NULL DEFAULT '',
    PRIMARY KEY (fid)
)
    ENGINE = ISAM;
