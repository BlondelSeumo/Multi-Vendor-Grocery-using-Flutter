import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/user.dart';
import 'package:quiver/core.dart';

class CommentDetail extends PsObject<CommentDetail> {
  CommentDetail({
    this.id,
    this.headerId,
    this.userId,
    this.detailComment,
    this.status,
    this.updatedDate,
    this.addedDate,
    this.commentReplyCount,
    this.addedDateStr,
    this.user,
  });
  String id;
  String headerId;
  String userId;
  String status;
  String addedDate;
  String detailComment;
  String updatedDate;
  String commentReplyCount;
  String addedDateStr;
  User user;

  @override
  bool operator ==(dynamic other) => other is CommentDetail && id == other.id;

  @override
  int get hashCode {
    return hash2(id.hashCode, id.hashCode);
  }

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  CommentDetail fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return CommentDetail(
        id: dynamicData['id'],
        headerId: dynamicData['header_id'],
        userId: dynamicData['user_id'],
        status: dynamicData['status'],
        addedDate: dynamicData['added_date'],
        detailComment: dynamicData['detail_comment'],
        updatedDate: dynamicData['updated_date'],
        commentReplyCount: dynamicData['comment_reply_count'],
        addedDateStr: dynamicData['added_date_str'],
        user: User().fromMap(dynamicData['user']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(CommentDetail object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['header_id'] = object.headerId;
      data['user_id'] = object.userId;
      data['status'] = object.status;
      data['added_date'] = object.addedDate;
      data['detail_comment'] = object.detailComment;
      data['updated_date'] = object.updatedDate;
      data['comment_reply_count'] = object.commentReplyCount;
      data['added_date_str'] = object.addedDateStr;
      data['user'] = User().toMap(object.user);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<CommentDetail> fromMapList(List<dynamic> dynamicDataList) {
    final List<CommentDetail> commentList = <CommentDetail>[];

    if (dynamicDataList != null) {
      for (dynamic dynamicData in dynamicDataList) {
        if (dynamicData != null) {
          commentList.add(fromMap(dynamicData));
        }
      }
    }
    return commentList;
  }

  @override
  List<Map<String, dynamic>> toMapList(List<CommentDetail> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (CommentDetail data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }
    return mapList;
  }
}
