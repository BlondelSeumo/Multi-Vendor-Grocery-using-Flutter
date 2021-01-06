import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/viewobject/user.dart';
import 'package:quiver/core.dart';

class ShopRating extends PsObject<ShopRating> {
  ShopRating({
    this.id,
    this.shopId,
    this.userId,
    this.rating,
    this.title,
    this.description,
    this.addedDate,
    this.addedDateStr,
    this.user,
  });
  String id;
  String shopId;
  String userId;
  String rating;
  String addedDate;
  String title;
  String updatedDate;
  String description;
  String addedDateStr;
  User user;

  @override
  bool operator ==(dynamic other) => other is ShopRating && id == other.id;

  @override
  int get hashCode {
    return hash2(id.hashCode, id.hashCode);
  }

  @override
  String getPrimaryKey() {
    return id;
  }

  @override
  ShopRating fromMap(dynamic dynamicData) {
    if (dynamicData != null) {
      return ShopRating(
        id: dynamicData['id'],
        shopId: dynamicData['shop_id'],
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
  Map<String, dynamic> toMap(ShopRating object) {
    if (object != null) {
      final Map<String, dynamic> data = <String, dynamic>{};
      data['id'] = object.id;
      data['shop_id'] = object.shopId;
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
  List<ShopRating> fromMapList(List<dynamic> dynamicDataList) {
    final List<ShopRating> commentList = <ShopRating>[];

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
  List<Map<String, dynamic>> toMapList(List<ShopRating> objectList) {
    final List<Map<String, dynamic>> mapList = <Map<String, dynamic>>[];
    if (objectList != null) {
      for (ShopRating data in objectList) {
        if (data != null) {
          mapList.add(toMap(data));
        }
      }
    }

    return mapList;
  }
}
