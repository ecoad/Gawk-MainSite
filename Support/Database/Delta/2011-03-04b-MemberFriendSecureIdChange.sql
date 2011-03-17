ALTER TABLE "MemberFriend" DROP COLUMN "MemberId";
ALTER TABLE "MemberFriend" DROP COLUMN "FriendId";

ALTER TABLE "MemberFriend" ADD COLUMN "MemberSecureId" text;
ALTER TABLE "MemberFriend" ADD COLUMN "FriendSecureId" text;

CREATE INDEX "MemberFriend_MemberSecureId_idx"
  ON "MemberFriend"
  USING btree
  ("MemberSecureId");
  
CREATE INDEX "MemberFriend_FriendSecureId_idx"
  ON "MemberFriend"
  USING btree
  ("FriendSecureId");