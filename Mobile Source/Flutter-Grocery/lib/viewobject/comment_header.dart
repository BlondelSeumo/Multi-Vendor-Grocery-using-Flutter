import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/user.dart';
import 'package:quiver/core.dart';

class CommentHeader extends PsObject<CommentHeader> {
  CommentHeader({
    this.id,
    this.productId,
    this.userId,
    this.headerComment,
    this.status,
    this.updatedDate,
    this.addedDate,
    this.commentReplyCount,
    this.addedDateStr,
    this.user,
  });
  String id;
  String productId;
  String userId;
  String status;
  String addedDate;
  String headerComment;
  String updatedDate;
  String commentReplyCount;
  String addedDateStr;
  User user;

  @override
  bool operator ==(dynamic other) => other is CommentHeader && id == other.id;

  @override
  int get hashCode {
    return hash2(id.hashCode, id.hashCode);
  }

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  CommentHeader fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return CommentHeader(
        id: dynamicData['id'],
        productId: dynamicData['product_id'],
        userId: dynamicData['user_id'],
        status: dynamicData['status'],
        addedDate: dynamicData['added_date'],
        headerComment: dynamicData['header_comment'],
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
  Map<String, dynamic> toMap(CommentHeader object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['product_id'] = object.productId;
      data['user_id'] = object.userId;
      data['status'] = object.status;
      data['added_date'] = object.addedDate;
      data['header_comment'] = object.headerComment;
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
  List<CommentHeader> fromMapList(List<dynamic> dynamicDataList) {
    final List<CommentHeader> commentList = <CommentHeader>[];

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
  List<Map<String, dynamic>> toMapList(List<CommentHeader> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (CommentHeader data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
