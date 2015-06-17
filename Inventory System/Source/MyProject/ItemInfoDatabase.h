// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "Engine/DataAsset.h"
#include "ItemInfoDatabase.generated.h"

/**
 * 
 */
USTRUCT()
struct FItemInfo
{
	GENERATED_USTRUCT_BODY()
	UPROPERTY(EditAnywhere, Category= "DATA", meta = (Tooltip= "The Mesh ID"))
	int32 MeshID;

	UPROPERTY(EditAnywhere, Category= "DATA", meta = (ToolTip= "Related Asset"))
	TAssetPtr<USkeletalMesh> MeshResource;

	FItemInfo():
		MeshID(0)
	{
		MeshResource= FStringAssetReference("");
	}
};

UCLASS()
class MYPROJECT_API UItemInfoDatabase : public UDataAsset
{
	GENERATED_UCLASS_BODY()
	UPROPERTY(EditAnywhere, Category= "Model List", meta= (ToolTip= "Asset Info"))
	TArray<FItemInfo> MeshList;

public:
	UItemInfoDatabase(UItemInfoDatabase&);
	UItemInfoDatabase();
};
