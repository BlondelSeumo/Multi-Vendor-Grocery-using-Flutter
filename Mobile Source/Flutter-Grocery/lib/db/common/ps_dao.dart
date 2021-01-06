import 'dart:async';
import 'dart:core';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/api/common/ps_resource.dart';
import 'package:fluttermultigrocery/db/common/ps_app_database.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_map_object.dart';
import 'package:fluttermultigrocery/viewobject/common/ps_object.dart';
import 'package:fluttermultigrocery/api/common/ps_status.dart';

abstract class PsDao<T extends PsObject<T>> {
  // dynamic dao;
  StoreRef<String, dynamic> dao;
  T obj;
  String sortingKey = 'sort';
  // Private getter to shorten the amount of code needed to get the
  // singleton instance of an opened database.
  Future<Database> get db async => await PsAppDatabase.instance.database;

  void init(T obj) {
    // A Store with int keys and Map<String, dynamic> values.
    // This Store acts like a persistent map, values of which are Fruit objects converted to Map
    dao = stringMapStoreFactory.store(getStoreName());
    this.obj = obj;
  }

  String getStoreName();

  dynamic getPrimaryKey(T object);
  Filter getFilter(T object);

  Future<dynamic> insert(String primaryKey, T object) async {
    // await deleteWithFinder(
    //     Finder(filter: Filter.equals(primaryKey, object.getPrimaryKey())));
    // await dao.add(await db, obj.toMap(object));
    await dao.record(object.getPrimaryKey()).put(await db, obj.toMap(object));
    return true;
  }

  Future<dynamic> insertAll(String primaryKey, List<T> objectList) async {
    final List<String> idList = <String>[];

    final dynamic recordSnapshots = await dao.find(
      await db,
      finder: Finder(),
    );

    int count = recordSnapshots.length;

    for (T data in objectList) {
      idList.add(data.getPrimaryKey());
    }
    // await deleteWithFinder(Finder(filter: Filter.inList(primaryKey, idList)));
    // await dao.addAll(await db, obj.toMapList(objectList));
    final List<Map<String, dynamic>> jsonList = obj.toMapList(objectList);
    for (int i = 0; i < jsonList.length; i++) {
      jsonList[i][sortingKey] = count++;
    }

    await dao.records(idList).put(await db, jsonList);
  }

  Future<dynamic> update(T object, {Finder finder}) async {
    // For filtering by key (ID), RegEx, greater than, and many other criteria,
    // we use a Finder.
    finder ??= Finder(filter: getFilter(object));

    return await dao.update(await db, obj.toMap(object), finder: finder);
  }

  Future<dynamic> updateWithFinder(T object, Finder finder) async {
    // For filtering by key (ID), RegEx, greater than, and many other criteria,
    // we use a Finder.
    await dao.update(
      await db,
      obj.toMap(object),
      finder: finder,
    );
  }

  Future<dynamic> deleteAll() async {
    await dao.delete(await db);
  }

  Future<dynamic> delete(T object, {Finder finder}) async {
    // For filtering by key (ID), RegEx, greater than, and many other criteria,
    // we use a Finder.
    finder ??= Finder(filter: getFilter(object));

    //final Finder finder = Finder(filter: finder);
    await dao.delete(
      await db,
      finder: finder,
    );
  }

  Future<dynamic> deleteWithFinder(Finder finder) async {
    await dao.delete(
      await db,
      finder: finder,
    );
  }

  Future<PsResource<List<T>>> getByKey(String key, String value,
      {List<SortOrder> sortOrderList,
      PsStatus status = PsStatus.SUCCESS}) async {
    final Finder finder = Finder(filter: Filter.equals(key, value));
    if (sortOrderList != null && sortOrderList.isNotEmpty) {
      finder.sortOrders = sortOrderList;
    }

    final dynamic recordSnapshots = await dao.find(
      await db,
      finder: finder,
    );
    final List<T> resultList = <T>[];
    recordSnapshots.forEach((dynamic snapshot) {
      resultList.add(obj.fromMap(snapshot.value));
    });

    return PsResource<List<T>>(status, '', resultList);
  }

  Future<dynamic> getAllWithSubscription(
      {StreamController<PsResource<List<T>>> stream,
      Finder finder,
      List<SortOrder> sortOrders,
      PsStatus status = PsStatus.SUCCESS,
      Function onDataUpdated}) async {
    finder ??= Finder();
    sortOrders ??= <SortOrder>[SortOrder(sortingKey, true)];
    finder.sortOrders = sortOrders;

    final dynamic query = dao.query(finder: finder);
    final dynamic subscription =
        await query.onSnapshots(await db).listen((dynamic recordSnapshots2) {
      final List<T> resultList = <T>[];
      recordSnapshots2.forEach((dynamic snapshot) {
        final T localObj = obj.fromMap(snapshot.value);
        localObj.key = snapshot.key;
        resultList.add(localObj);
      });

      onDataUpdated(resultList);
    });

    return subscription;
  }

  Future<PsResource<List<T>>> getAll(
      {Finder finder,
      List<SortOrder> sortOrders,
      PsStatus status = PsStatus.SUCCESS}) async {
    finder ??= Finder();
    sortOrders ??= <SortOrder>[SortOrder(sortingKey, true)];
    finder.sortOrders = sortOrders;

    final dynamic recordSnapshots = await dao.find(
      await db,
      finder: finder,
    );
    final List<T> resultList = <T>[];
    recordSnapshots.forEach((dynamic snapshot) {
      final T localObj = obj.fromMap(snapshot.value);
      localObj.key = snapshot.key;
      resultList.add(localObj);
    });

    return PsResource<List<T>>(status, '', resultList);
  }

  Future<PsResource<T>> getOne(
      {Finder finder, PsStatus status = PsStatus.SUCCESS}) async {
    finder ??= Finder();
    final dynamic recordSnapshots = await dao.find(
      await db,
      finder: finder,
    );
    T result;

    for (dynamic snapshot in recordSnapshots) {
      final T localObj = obj.fromMap(snapshot.value);
      localObj.key = snapshot.key;
      result = localObj;
      break;
    }

    return PsResource<T>(status, '', result);
  }

  Future<PsResource<List<T>>> getAllByJoin<K extends PsMapObject<dynamic>>(
      String primaryKey, PsDao<PsObject<dynamic>> mapDao, dynamic mapObj,
      {List<SortOrder> sortOrderList,
      PsStatus status = PsStatus.SUCCESS}) async {
    final PsResource<List<PsObject<dynamic>>> dataList = await mapDao.getAll(
        finder: Finder(sortOrders: <SortOrder>[SortOrder('sorting', true)]));

    final List<String> valueList = mapObj.getIdList(dataList.data);

    final Finder finder = Finder(
      filter: Filter.inList(primaryKey, valueList),
      //sortOrders: [SortOrder(Field.key, true)]
    );
    if (sortOrderList != null && sortOrderList.isNotEmpty) {
      finder.sortOrders = sortOrderList;
    }

    final dynamic recordSnapshots = await dao.find(
      await db,
      finder: finder,
    );
    final List<T> resultList = <T>[];

    // sorting
    for (String id in valueList) {
      for (dynamic snapshot in recordSnapshots) {
        if (snapshot.value[primaryKey] == id) {
          resultList.add(obj.fromMap(snapshot.value));
          break;
        }
      }
    }

    return PsResource<List<T>>(status, '', resultList);
  }

  Future<PsResource<List<T>>>
      getAllDataListWithFilterId<K extends PsMapObject<dynamic>>(
          String filterId,
          String filterIdKey,
          PsDao<PsObject<dynamic>> mapDao,
          dynamic mapObj,
          {List<SortOrder> sortOrderList,
          PsStatus status = PsStatus.SUCCESS}) async {
    final PsResource<List<PsObject<dynamic>>> dataList = await mapDao.getAll(
        finder: Finder(sortOrders: <SortOrder>[
      SortOrder('sorting', true),
    ], filter: Filter.equals(filterIdKey, filterId)));

    final List<String> valueList = mapObj.getIdList(dataList.data);
    print(valueList.length);
    //  code close

    final Finder finder = Finder(
      filter: Filter.inList('id', valueList),
    );
    if (sortOrderList != null && sortOrderList.isNotEmpty) {
      finder.sortOrders = sortOrderList;
    }

    final dynamic recordSnapshots = await dao.find(
      await db,
      finder: finder,
    );
    final List<T> resultList = <T>[];

    // sorting
    for (String id in valueList) {
      for (dynamic snapshot in recordSnapshots) {
        if (snapshot.value['id'] == id) {
          resultList.add(obj.fromMap(snapshot.value));
          break;
        }
      }
    }

    return PsResource<List<T>>(status, '', resultList);
  }

  Future<PsResource<List<T>>> getAllByMap<K extends PsMapObject<dynamic>>(
      String primaryKey,
      String mapKey,
      String paramKey,
      PsDao<PsObject<dynamic>> mapDao,
      dynamic mapObj,
      {List<SortOrder> sortOrderList,
      PsStatus status = PsStatus.SUCCESS}) async {
    final PsResource<List<PsObject<dynamic>>> dataList = await mapDao.getAll(
        finder: Finder(
            filter: Filter.equals(mapKey, paramKey),
            sortOrders: <SortOrder>[SortOrder('sorting', true)]));

    final List<String> valueList = mapObj.getIdList(dataList.data);

    final Finder finder = Finder(
      filter: Filter.inList(primaryKey, valueList),
      //sortOrders: [SortOrder(Field.key, true)]
    );
    if (sortOrderList != null && sortOrderList.isNotEmpty) {
      finder.sortOrders = sortOrderList;
    }

    final dynamic recordSnapshots = await dao.find(
      await db,
      finder: finder,
    );
    final List<T> resultList = <T>[];

    // sorting
    for (String id in valueList) {
      for (dynamic snapshot in recordSnapshots) {
        if (snapshot.value[primaryKey] == id) {
          resultList.add(obj.fromMap(snapshot.value));
          break;
        }
      }
    }

    return PsResource<List<T>>(status, '', resultList);
  }
}
