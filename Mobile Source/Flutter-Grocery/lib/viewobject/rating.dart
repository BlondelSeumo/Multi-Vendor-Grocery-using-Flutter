import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/user.dart';
import 'package:quiver/core.dart';

class Rating extends PsObject<Rating> {
  Rating({
    this.id,
    this.productId,
    this.userId,
    this.rating,
    this.title,
    this.description,
    this.addedDate,
    this.addedDateStr,
    this.user,
  });
  String id;
  String productId;
  String userId;
  String rating;
  String addedDate;
  String title;
  String updatedDate;
  String description;
  String addedDateStr;
  User user;

  @override
  bool operator ==(dynamic other) => other is Rating && id == other.id;

  @override
  int get hashCode {
    return hash2(id.hashCode, id.hashCode);
  }

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  Rating fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return Rating(
        id: dynamicData['id'],
        productId: dynamicData['product_id'],
        userId: dynamicData['user_id'],
        addedDate: dynamicData['added_date'],
        rating: dynamicData['rating'],
        title: dynamicData['title'],
        description: dynamicData['description'],
        addedDateStr: dynamicData['added_date_str'],
        user: User().fromMap(dynamicData['user']),
      );
    } else {
      return null;
    }
  }

  @override
  Map<String, dynamic> toMap(Rating object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['product_id'] = object.productId;
      data['user_id'] = object.userId;
      data['added_date'] = object.addedDate;
      data['title'] = object.title;
      data['rating'] = object.rating;
      data['description'] = object.description;
      data['added_date_str'] = object.addedDateStr;
      data['user'] = User().toMap(object.user);
      return data;
    } else {
      return null;
    }
  }

  @override
  List<Rating> fromMapList(List<dynamic> dynamicDataList) {
    final List<Rating> commentList = <Rating>[];

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
  List<Map<String, dynamic>> toMapList(List<Rating> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (Rating data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
